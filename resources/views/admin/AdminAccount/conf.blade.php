@extends('admin.layouts.admin_main')

@section('title','管理者アカウント 確認')

@section('breadcrumb')
    @includeIf('admin.AdminAccount.breadcrumb')
@endsection

@section('content')
@php
    $p = $input->getProcessParams()->toArray();
@endphp

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        {{ $p['id'] ?? '' ? '更新' : '新規登録' }}
        （入力内容確認）
    </div>

    <div class="card-body">
        <form method="post">
            @csrf
        @if (($p['id'] ?? '') !== '')
            <input type="hidden" name="id" value="{{ $p['id'] ?? '' }}">
            <input type="hidden" name="modified_at" value="{{ $p['modified_at'] ?? '' }}">
        @endif
            <input type="hidden" name="_process_key" value="{{ $p['_process_key'] ?? '' }}">
            <table class="table table-bordered">
                <tr>
                    <th style="width:30%">ID</th>
                    <td>{{ $p['id'] ?? '（新規作成）' }}</td>
                </tr>
            </table>

            <h6 class="border-bottom pb-2 mb-3">アカウント情報</h6>
            <table class="table table-bordered">
                <tr>
                    <th style="width:30%">メールアドレス</th>
                    <td>{{ $p['email'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td>
                    @if (($p['id'] ?? '') === '')
                        **（セキュリティのため表示されません）**
                    @else
                        {{ ($p['password']?? '') !== '' ? '（変更あり）' : '（変更なし）' }} 
                    @endif
                    </td>
                </tr>
                <tr>
                    <th>名前</th>
                    <td>{{ $p['name'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>管理者メモ</th>
                    <td style="white-space:pre-wrap">{{ $p['admin_note'] ?? '' }}</td>
                </tr>
            </table>

            <h6 class="border-bottom pb-2 mb-3">ステータス・権限</h6>
            <table class="table table-bordered">
                <tr>
                    <th style="width:30%">アカウントステータス</th>
                    <td>
                @foreach ($accountStatusOptions as $option)
                    @if (($p['account_status_master_id'] ?? '') === $option->accountStatusMasterId()->toString())
                        {{ $option->accountStatusMasterName()->toString() }}
                    @endif
                @endforeach
                    </td>
                </tr>
                <tr>
                    <th>メール確認</th>
                    <td>{{ $p['is_email_verified']!== '0' ? 'はい' : 'いいえ' }}</td>
                </tr>
            </table>

            <h6 class="border-bottom pb-2 mb-3">パスワード管理</h6>
            <table class="table table-bordered">
                <tr>
                    <th style="width:30%">パスワード変更日時</th>
                    <td>{{ $p['password_changed_at'] }}</td>
                </tr>
                <tr>
                    <th>パスワード有効期限</th>
                    <td>{{ $p['password_expires_at'] }}</td>
                </tr>
            </table>

            <div class="text-center mt-4">
            @if (($p['id'] ?? '') === '')
                <a 
                    href="{{ route('admin.admin_account.create.input', [
                        'account_id' => request()->route('account_id'), 
                        'process_id' => request()->route('process_id'), 
                        ...request()->query(),
                    ]) }}" 
                    class="btn btn-secondary px-5"
                >修正する</a>
            @endif
            @if (($p['id'] ?? '') !== '')
                <a 
                    href="{{ route('admin.admin_account.edit.input', [
                        'account_id' => request()->route('account_id'), 
                        'process_id' => request()->route('process_id'), 
                        ...request()->query(),
                    ]) }}" 
                    class="btn btn-secondary px-5"
                >修正する</a>
            @endif
                <button type="submit" name="_process_action" value="complete" class="btn btn-success px-5 me-3">
                    登録する
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
