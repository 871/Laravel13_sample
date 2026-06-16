@extends('admin.layouts.admin_main')

@section('title','ユーザーアカウント 詳細')

@section('breadcrumb')
    @includeIf('admin.UserAccount.breadcrumb')
@endsection

@section('content')
@includeIf('admin.shared.flash')

<h4>ユーザーアカウント 詳細</h4>

<div class="card shadow-sm mb-3">
    <div class="card-header bg-info text-white">
        詳細表示
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:30%">ID</th>
                <td>{{ $userAccount->id()->toString() }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ $userAccount->email()->toString() }}</td>
            </tr>
            <tr>
                <th>名前</th>
                <td>{{ $userAccount->name()->toString() }}</td>
            </tr>
            <tr>
                <th>アカウントステータス</th>
                <td>{{ $userAccount->accountStatusMasterName()->toString() }}</td>
            </tr>
            <tr>
                <th>メール確認</th>
                <td>{{ $userAccount->isEmailVerified()->toInt() ? '確認済み' : '未確認' }}</td>
            </tr>
            <tr>
                <th>パスワード変更日時</th>
                <td>{{ $userAccount->passwordChangedAt()->format('Y/m/d H:i:s') ?? '----/--/-- --:--:--' }}</td>
            </tr>
            <tr>
                <th>パスワード有効期限</th>
                <td>{{ $userAccount->passwordExpiresAt()->format('Y/m/d H:i:s') ?? '----/--/-- --:--:--' }}</td>
            </tr>
        </table>

        <div class="text-center mt-4">
            <a 
                href="{{ route('admin.user_account.search.index', [
                    'account_id' => request()->route('account_id'), 
                    ...request()->query(),
                ]) }}" 
                class="btn btn-secondary px-5"
            >戻る</a>
            <a 
                href="{{ route('admin.user_account.edit.index', [
                    'account_id' => request()->route('account_id'),
                    'user_account_id' => request()->route('user_account_id'),
                    ...request()->query(),
                ]) }}"
                class="btn btn-primary px-5"
            >更新</a>
            <a 
                href="{{ route('admin.user_account.create.copy', [
                    'account_id' => request()->route('account_id'),
                    'user_account_id' => request()->route('user_account_id'),
                    ...request()->query(),
                ]) }}"
                class="btn btn-primary px-5"
            >複製</a>
            <form method="POST"
                action="{{ route('admin.user_account.delete.index', [
                    'account_id' => request()->route('account_id'),
                    'user_account_id' => request()->route('user_account_id'),
                    ...request()->query(),
                ]) }}"
                class="d-inline"
            >
                @csrf
                @method('POST')
            </form>
            <a 
                href="#" 
                onclick="if (confirm('削除しますか？')) { this.previousElementSibling.submit(); } return false;"
                class="btn btn-danger px-5"
            >
                削除
            </a>
        </div>
    </div>
</div>

<!-- 履歴 -->
<div class="card shadow-sm">
    <div class="card-header bg-secondary text-white">
        変更履歴
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr >
                    <th class="text-black-50">履歴日時</th>
                    <th class="text-black-50">操作</th>
                    <th class="text-black-50">メールアドレス</th>
                    <th class="text-black-50">名前</th>
                    <th class="text-black-50">ステータス</th>
                    <th class="text-black-50">メール確認</th>
                    <th class="text-black-50">PW変更日時</th>
                    <th class="text-black-50">PW有効期限</th>
                </tr>
            </thead>
            <tbody>
            @if(count($userAccountHistories) === 0)
                <tr>
                    <td colspan="8" class="text-center text-muted py-3">履歴がありません</td>
                </tr>
            @endif
            @foreach ($userAccountHistories as $history)
                <tr>
                    <td>{{ $history->historyCreated()->format('Y/m/d H:i:s') ?? '' }}</td>
                    <td>
                        {!! match ($history->operationType()) {
                            'INSERT' => '<span class="badge bg-success">作成</span>',
                            'UPDATE' => '<span class="badge bg-primary">更新</span>',
                            'DELETE' => '<span class="badge bg-danger">削除</span>',
                            default => e($history->operationType()),
                        } !!}
                    </td>
                    <td>{{ $history->email()->toString() }}</td>
                    <td>{{ $history->name()->toString() }}</td>
                    <td>{{ $history->accountStatusMasterName()->toString() }}</td>
                    <td>{{ $history->isEmailVerified()->toInt() ? '確認済み' : '未確認' }}</td>
                    <td>{{ $history->passwordChangedAt()->format('Y/m/d H:i:s') ?? '' }}</td>
                    <td>{{ $history->passwordExpiresAt()->format('Y/m/d H:i:s') ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection