@extends('admin.layouts.admin_main')

@section('title','ユーザーアカウント 詳細')

@section('breadcrumb')
    @includeIf('admin.UserAccount.breadcrumb')
@endsection

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            ユーザーアカウント 詳細
        </div>
        <div>
            <a href="{{ route('admin.user_account.edit.index', array_merge(request()->query(), ['account_id' => request()->route('account_id'), 'user_account_id' => $detail->id()->toString()])) }}" class="btn btn-primary btn-sm">編集</a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:30%">ID</th>
                <td>{{ e($detail->id()) }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ e($detail->email()) }}</td>
            </tr>
            <tr>
                <th>名前</th>
                <td>{{ e($detail->name()) }}</td>
            </tr>
            <tr>
                <th>ステータス</th>
                <td>{{ e($detail->accountStatusMasterName()) }}</td>
            </tr>
            <tr>
                <th>メール確認</th>
                <td>{{ $detail->isEmailVerified()->toInt() ? '確認済み' : '未確認' }}</td>
            </tr>
            <tr>
                <th>パスワード変更日時</th>
                <td>{{ e($detail->passwordChangedAt()->format('Y/m/d H:i:s')) }}</td>
            </tr>
        </table>

        <h6 class="mt-4">変更履歴</h6>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>日時</th>
                    <th>差分</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($histories as $h)
                    <tr>
                        <td>{{ e($h->createdAt()->format('Y/m/d H:i:s')) }}</td>
                        <td>{!! nl2br(e($h->diff())) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection