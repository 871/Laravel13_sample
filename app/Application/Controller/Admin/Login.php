<?php

declare(strict_types=1);

namespace App\Application\Controller\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Domain\Admin\AdminAccounts\ValueObject\Email as EmailVo;
use App\Domain\Admin\AdminAccounts\ValueObject\Password as PasswordVo;
use App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository as EloquentRepo;

final class Login
{
    public function show()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable',
        ]);

        $emailVo = new EmailVo($data['email']);
        $passwordVo = new PasswordVo($data['password']);

        // Use Eloquent repository implementation directly
        $repo = new EloquentRepo(new \DateTimeImmutable());
        $admin = $repo->findByEmail($emailVo);

        if ($admin === null) {
            return back()->withInput()->with('error', 'メールアドレスまたはパスワードが違います。');
        }

        $dbPassword = $admin->password()->toString();
        $ok = false;

        try {
            if (!empty($dbPassword) && Hash::check($passwordVo->toString(), $dbPassword)) {
                $ok = true;
            }
        } catch (\Throwable $e) {
            // ignore
        }

        if (!$ok) {
            if ($dbPassword === $passwordVo->toString()) {
                $ok = true; // legacy raw match
            }
        }

        if (!$ok) {
            return back()->withInput()->with('error', 'メールアドレスまたはパスワードが違います。');
        }

        // set session for admin_user
        session(['admin_user' => [
            'id' => $admin->id()->toString(),
            'name' => $admin->name()->toString(),
            'email' => $admin->email()->toString(),
        ]]);

        return redirect()->to('/v1/ad/' . $admin->id()->toString() . '/')->with('success', 'ログインしました。');
    }
}
