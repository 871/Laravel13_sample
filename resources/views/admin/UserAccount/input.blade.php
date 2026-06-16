@extends('admin.layouts.admin_main')

@section('title','ユーザーアカウント 入力')

@section('breadcrumb')
    @includeIf('admin.UserAccount.breadcrumb')
@endsection

@section('content')

@php
    $p = $input->getProcessParams()->toArray();
@endphp

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">ユーザーアカウント 入力</div>

    <div class="card-body">
        <form method="post" action="{{ route($routeName, array_merge(request()->query(), ['account_id' => request()->route('account_id')] )) }}">
            @csrf

            <input type="hidden" name="_process_key" value="{{ $p['_process_key'] ?? '' }}">

            <div class="mb-3">
                <label class="form-label">メールアドレス</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $p['email'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">パスワード</label>
                <input type="password" name="password" class="form-control">
                @if (($p['id'] ?? '') !== '')
                    <div class="form-text">変更しない場合は空欄にしてください。</div>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">名前</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $p['name'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">アカウントステータス</label>
                <select name="account_status_master_id" class="form-select">
                    @foreach ($accountStatusOptions as $option)
                        <option value="{{ $option->accountStatusMasterId()->toString() }}" {{ (old('account_status_master_id', $p['account_status_master_id'] ?? '') === $option->accountStatusMasterId()->toString()) ? 'selected' : '' }}>{{ $option->accountStatusMasterName()->toString() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">メール確認</label>
                <select name="is_email_verified" class="form-select">
                    <option value="1" {{ (old('is_email_verified', $p['is_email_verified'] ?? '') === '1') ? 'selected' : '' }}>はい</option>
                    <option value="0" {{ (old('is_email_verified', $p['is_email_verified'] ?? '') === '0') ? 'selected' : '' }}>いいえ</option>
                </select>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">次へ</button>
            </div>
        </form>
    </div>
</div>
@endsection