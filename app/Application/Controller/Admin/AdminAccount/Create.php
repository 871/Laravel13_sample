<?php
declare(strict_types=1);

namespace App\Application\Controller\Admin\AdminAccount;

use App\Application\Controller\Admin\AdminAccount\Shared\ValidatorSetting;
use App\Application\Controller\Shared\Process\Process\Fields\ProcessId;
use App\Application\Controller\Shared\Process\Process\Fields\ProcessParams;
use App\Application\Controller\Shared\Process\Process\InputProcess;
use App\Application\Controller\Shared\Process\ProcessDeleter;
use App\Application\Controller\Shared\Process\ProcessFactory;
use App\Application\Controller\Shared\Process\ProcessProvider;
use App\Application\Controller\Shared\Process\ProcessRepository;
use App\Application\Controller\Shared\Process\ProcessNotFoundException;
use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use App\Exception\ValidateException;
use App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts\AdminAccountsRepository;
use App\Security\Input\Cast;
use App\Security\Input\StrictCast;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use DomainException;

final class Create implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * @return \App\Application\Controller\Shared\Process\Process\InputProcess
     */
    public function startInputProcess(): InputProcess
    {
        /** @var \App\Application\Controller\Shared\Process\ProcessFactory $processFactory */
        $processFactory = $this->createApplication(ProcessFactory::class);
        /** @var \App\Application\Controller\Shared\Process\Process\InputProcess $process */
        $process = $processFactory->start(
            processClassName: InputProcess::class,
            processParams: new ProcessParams([
                '_errorMessages' => [],
                '_errorFields' => [],
                '_process_key' => Uuid::uuid4()->toString(),
                'email' => '',
                'password' => '',
                'name' => '',
                'admin_note' => '',
                'account_status_master_id' => '',
                'is_email_verified' => '0',
                'password_changed_at' => '',
                'password_expires_at' => '',
            ]),
        );

        return $process;
    }

    /**
     * @return \App\Application\Controller\Shared\Process\Process\InputProcess
     */
    public function startInputProcessForCopy(): InputProcess
    {
        $adminAccount = (new AdminAccountsRepository($this->datetime))->read(
            new Vo\Id(
                StrictCast::toString($this->request->route('admin_account_id')),
            ),
        );

        /** @var \App\Application\Controller\Shared\Process\ProcessFactory $processFactory */
        $processFactory = $this->createApplication(ProcessFactory::class);
        /** @var \App\Application\Controller\Shared\Process\Process\InputProcess $process */
        $process = $processFactory->start(
            processClassName: InputProcess::class,
            processParams: new ProcessParams([
                '_errorMessages' => [],
                '_errorFields' => [],
                '_process_key' => Uuid::uuid4()->toString(),
                'email' => '',
                'password' => '',
                'name' => $adminAccount->name()->toString(),
                'admin_note' => $adminAccount->adminNote()->toString(),
                'account_status_master_id' => $adminAccount->accountStatusMasterId()->toString(),
                'is_email_verified' => $adminAccount->isEmailVerified()->toString(),
                'password_changed_at' => $adminAccount->passwordChangedAt()->toString(),
                'password_expires_at' => $adminAccount->passwordExpiresAt()->toString(),
            ]),
        );

        return $process;
    }

    /**
     * @return \App\Application\Controller\Shared\Process\Process\InputProcess
     */
    public function getInputProcess(): InputProcess
    {
        /** @var \App\Application\Controller\Shared\Process\ProcessProvider $processProvider */
        $processProvider = $this->createApplication(ProcessProvider::class);
        /** @var \App\Application\Controller\Shared\Process\Process\InputProcess $inputProcess */
        $inputProcess = $processProvider->provide(
            processClassName: InputProcess::class,
            processId: new ProcessId(
                StrictCast::toString($this->request->route('process_id')),
            ),
        ) ?? throw new ProcessNotFoundException(
            StrictCast::toString($this->request->route('process_id'))
        );

        return $inputProcess;
    }

    /**
     * @return self
     */
    public function inputProcessUpdate(): self
    {
        $inputProcess = $this->getInputProcess();
        $inputProcessParams = $inputProcess->getProcessParams();
        if (!$this->checkProcessKey($inputProcess)) {
            throw new ValidateException([
                '_process_key' => [
                    'notMatch' => __('別プロセスで更新されました。'),
                ],
            ]);
        }
        /** @var \App\Application\Controller\Shared\Process\ProcessRepository $processRepository */
        $processRepository = $this->createApplication(ProcessRepository::class);
        $processRepository->save(
            process: $inputProcess->setProcessParams(
                processParams: $inputProcessParams->with(
                    overrides: $this->getOverwriteParams(),
                ),
            ),
        );

        return $this;
    }

    /**
     * @param \App\Application\Controller\Shared\Process\Process\InputProcess $inputProcess
     * @return bool
     */
    private function checkProcessKey(InputProcess $inputProcess): bool
    {
        return $inputProcess->getProcessParams()->hasParam(
            path: '_process_key',
            samValue: $this->request->input('_process_key'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function getOverwriteParams(): array
    {
        return [
            '_errorMessages' => [],
            '_errorFields' => [],
            '_process_key' => Uuid::uuid4()->toString(),
            'email' => $this->request->input('email'),
            'password' => $this->request->input('password'),
            'name' => $this->request->input('name'),
            'admin_note' => $this->request->input('admin_note'),
            'account_status_master_id' => $this->request->input('account_status_master_id'),
            'is_email_verified' => $this->request->input('is_email_verified') ?? '0',
            'password_changed_at' => $this->request->input('password_changed_at'),
            'password_expires_at' => $this->request->input('password_expires_at'),
        ];
    }

    /**
     * @return self
     */
    public function inputProcessValidation(): self
    {
        $validator = Validator::make(
            data: $this->getInputProcess()
                ->getProcessParams()
                ->toArray(), 
            rules: [
                'email' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        (new AdminAccountsRepository($this->datetime))->findByEmail(
                            email: new Vo\Email($value),
                        ) !== null && $fail('入力されたメールアドレスは既に使用されています。');
                    },
                    function ($attribute, $value, $fail) {
                        try {
                            new Vo\Email($value);
                        } catch (DomainException $e) {
                            $message = match ($e->getCode()) {
                                Vo\Email::ERROR_CODE_INVALID_FORMAT => 'メールアドレスの形式が正しくありません。',
                                Vo\Email::ERROR_CODE_TOO_LONG => sprintf('メールアドレスは%s文字以内で入力してください。', Vo\Email::MAX_LENGTH),
                                default => 'メールアドレスの入力が不正です。',
                            };
                            $fail($message);
                        }
                    },
                ],
                'password' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        try {
                            new Vo\Password($value);
                        } catch (DomainException $e) {
                            $message = match ($e->getCode()) {
                                Vo\Password::ERROR_CODE_TOO_LONG => sprintf('パスワードは%s文字以内で入力してください。', Vo\Password::MAX_LENGTH),
                                default => 'パスワードの入力が不正です。',
                            };
                            $fail($message);
                        }
                    },
                ],
                'name' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        try {
                            new Vo\Name($value);
                        } catch (DomainException $e) {
                            $message = match ($e->getCode()) {
                                Vo\Name::ERROR_CODE_TOO_LONG => sprintf('表示名は%s文字以内で入力してください。', Vo\Name::MAX_LENGTH),
                                default => '表示名の入力が不正です。',
                            };
                            $fail($message);
                        }
                    },
                ],
                'admin_note' => [
                    function ($attribute, $value, $fail) {
                        try {
                            new Vo\AdminNote($value);
                        } catch (DomainException $e) {
                            $message = match ($e->getCode()) {
                                Vo\AdminNote::ERROR_CODE_TOO_LONG => sprintf('管理者メモは%s文字以内で入力してください。', Vo\AdminNote::MAX_LENGTH),
                                default => '管理者メモの入力が不正です。',
                            };
                            $fail($message);
                        }
                    },
                ],
                'account_status_master_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        array_filter(
                            (new AdminAccountsRepository($this->datetime))->getAccountStatusOptions(), 
                            function ($option) use ($value) {
                                return $option->accountStatusMasterId()->toString() === (string)$value;
                            },
                        ) === [] && $fail('選択されたアカウントステータスは存在しません。');
                    },
                    function ($attribute, $value, $fail) {
                        try {
                            new Vo\AccountStatusMasterId($value);
                        } catch (DomainException $e) {
                            $message = match ($e->getCode()) {
                                Vo\AccountStatusMasterId::ERROR_CODE_INVALID_FORMAT => 'アカウントステータスの形式が正しくありません。',
                                default => 'アカウントステータスの入力が不正です。',
                            };
                            $fail($message);
                        }
                    },
                ],
                'is_email_verified' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        try {
                            new Vo\IsEmailVerified($value);
                        } catch (DomainException $e) {
                            $message = match ($e->getCode()) {
                                Vo\IsEmailVerified::ERROR_CODE_OUT_OF_RANGE => 'メールアドレス確認済みの形式が正しくありません。',
                                default => 'メールアドレス確認済みの入力が不正です。',
                            };
                            $fail($message);
                        }
                    },
                ],
                'password_changed_at' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        try {
                            new Vo\PasswordChangedAt($value);
                        } catch (DomainException $e) {
                            $message = match ($e->getCode()) {
                                Vo\PasswordChangedAt::ERROR_CODE_INVALID_FORMAT => 'パスワード変更日時は正しい日時形式で入力してください。',
                                default => 'パスワード変更日時の入力が不正です。',
                            };
                            $fail($message);
                        }
                    },
                ],
                'password_expires_at' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        try {
                            new Vo\PasswordExpiresAt($value);
                        } catch (DomainException $e) {
                            $message = match ($e->getCode()) {
                                Vo\PasswordExpiresAt::ERROR_CODE_INVALID_FORMAT => 'パスワード有効期限は正しい日時形式で入力してください。',
                                default => 'パスワード有効期限の入力が不正です。',
                            };
                            $fail($message);
                        }
                    },
                ],
            ], 
            messages: [
                'email.required' => 'メールアドレスは必須です。',
                'password.required' => 'パスワードは必須です。',
                'name.required' => '表示名は必須です。',
                'account_status_master_id.required' => 'アカウントステータスは必須です。',
                'is_email_verified.required' => 'メールアドレス確認済みは必須です。',
                'password_changed_at.required' => 'パスワード変更日時は必須です。',
                'password_expires_at.required' => 'パスワード有効期限は必須です。',
            ],
            attributes: [
                'email' => 'メールアドレス',
                'password' => 'パスワード',
                'name' => '表示名',
                'admin_note' => '管理者メモ',
                'account_status_master_id' => 'アカウントステータス',
                'is_email_verified' => 'メールアドレス確認済み',
                'password_changed_at' => 'パスワード変更日時',
                'password_expires_at' => 'パスワード有効期限',
            ],
        );

        if ($validator->fails()) {
            throw new ValidateException($validator->errors()->toArray());
        }

        return $this;
    }

    /**
     * @return self
     */
    public function saveInputProcess(): self
    {
        /** @var array<string, mixed> $input */
        $input = $this->getInputProcess()
            ->getProcessParams()
            ->toArray();

        (new AdminAccountsRepository($this->datetime))->create(new AdminAccount(
            id: new Vo\Id(null),
            email: Vo\Email::fromString(Cast::toStringOrNull($input['email'])),
            password: Vo\Password::fromString(Cast::toStringOrNull($input['password'])),
            name: Vo\Name::fromString(Cast::toStringOrNull($input['name'])),
            admin_note: Vo\AdminNote::fromString(Cast::toStringOrNull($input['admin_note'])),
            account_status_master_id: new Vo\AccountStatusMasterId(
                Cast::toStringOrNull($input['account_status_master_id']),
            ),
            account_status_master_code: new Vo\AccountStatusMasterCode(null),
            account_status_master_name: new Vo\AccountStatusMasterName(null),
            is_email_verified: new Vo\IsEmailVerified(Cast::toStringOrNull($input['is_email_verified'])),
            password_changed_at: new Vo\PasswordChangedAt(Cast::toStringOrNull($input['password_changed_at'])),
            password_expires_at: new Vo\PasswordExpiresAt(Cast::toStringOrNull($input['password_expires_at'])),
            created_at: new SVo\CreatedAt(Cast::toStringOrNull($this->datetime->format('Y-m-d\\TH:i:s'))),
            created_by: new SVo\CreatedBy(Cast::toStringOrNull($this->authContext->getAccountId())),
            created_ip: new SVo\CreatedIp(Cast::toStringOrNull($this->request->ip())),
            modified_at: new SVo\ModifiedAt(Cast::toStringOrNull($this->datetime->format('Y-m-d\\TH:i:s'))),
            modified_by: new SVo\ModifiedBy(Cast::toStringOrNull($this->authContext->getAccountId())),
            modified_ip: new SVo\ModifiedIp(Cast::toStringOrNull($this->request->ip())),
        ));

        return $this;
    }

    /**
     * @return self
     */
    public function endInputProcess(): self
    {
        /** @var \App\Application\Controller\Shared\Process\ProcessDeleter $processDeleter */
        $processDeleter = $this->createApplication(ProcessDeleter::class);
        $processDeleter->delete(
            process: $this->getInputProcess(),
        );

        return $this;
    }

    /**
     * @param \App\Exception\ValidateException $ex
     * @return self
     */
    public function inputProcessErrorUpdate(ValidateException $ex): self
    {
        $inputProcess = $this->getInputProcess();
        $inputProcessParams = $inputProcess->getProcessParams();
        /** @var \App\Application\Controller\Shared\Process\ProcessRepository $processRepository */
        $processRepository = $this->createApplication(ProcessRepository::class);
        $processRepository->save(
            process: $inputProcess->setProcessParams(
                processParams: $inputProcessParams->with(
                    overrides: [
                        '_errorMessages' => $ex->getErrorMessages(),
                        '_errorFields' => $ex->getErrorFields(),
                    ],
                ),
            ),
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getAccountStatusOptions(): array
    {
        return (new AdminAccountsRepository($this->datetime))->getAccountStatusOptions();
    }
}
