@extends('admin.layouts.admin_main')

@section('title','管理者アカウント 入力')

@section('breadcrumb')
    @includeIf('admin.AdminAccount.breadcrumb')
@endsection

@section('content')
@php
    $p = $input->getProcessParams()->toArray();
@endphp
<!-- フォームカード -->
<div class="card shadow-sm">
<?php foreach ($p['_errorMessages'] ?? [] as $message) { ?>
    <div class="alert alert-error-custom" onclick="this.style.display='none'">
        {{ $message }}
    </div>
<?php } ?>
    <div class="card-header bg-primary text-white">
        {{ ($p['id'] ?? '') ? '更新' : '新規登録' }}
    </div>
    <div class="card-body">
        <form method="post">
            @csrf
            <input type="hidden" name="_process_key" value="{{ $p['_process_key'] ?? '' }}">
        @if (($p['id'] ?? '') !== '')
            <input type="hidden" name="id" value="{{ $p['id'] ?? '' }}">
            <input type="hidden" name="modified_at" value="{{ $p['modified_at'] ?? '' }}">
        @endif
            <h6 class="border-bottom pb-2 mb-3">アカウント情報</h6>
            <div class="row mb-3">
                <div class="col-md-12 mb-2">
                    <label class="form-label">ID </label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $p['id'] ?? '（新規作成）' }}"
                        readonly
                    >
                </div>
                <div class="col-md-12 mb-2">
                    <label class="form-label">メールアドレス <span class="text-danger">*</span></label>
                    <input
                        type="email"
                        name="email"
                        class="form-control {{ $p['_errorFields']['email'] ?? '' }}"
                        value="{{ $p['email'] ?? '' }}"
                        maxlength="255"
                        required
                    >
                </div>
                <div class="col-md-12 mb-2">
                    <label class="form-label">
                        パスワード {!! ($p['id'] ?? '') ? '' : '<span class="text-danger">*</span>' !!}
                    </label>
                    @if ($p['id'] ?? '')
                        <div class="form-text text-muted mb-1">空白の場合は現在のパスワードを維持します。</div>
                    @endif
                    <input
                        type="password"
                        name="password"
                        class="form-control {{ $p['_errorFields']['password'] ?? '' }}"
                        autocomplete="new-password"
                    >
                </div>
                <div class="col-md-12 mb-2">
                    <label class="form-label">名前 <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="name"
                        class="form-control {{ $p['_errorFields']['name'] ?? '' }}"
                        value="{{ $p['name'] ?? '' }}"
                        maxlength="100"
                        required
                    >
                </div>
                <div class="col-md-12 mb-2">
                    <label class="form-label">管理者メモ</label>
                    <textarea
                        name="admin_note"
                        class="form-control {{ $p['_errorFields']['admin_note'] ?? '' }}"
                        rows="3"
                    >{{ $p['admin_note'] ?? '' }}</textarea>
                </div>
            </div>

            <h6 class="border-bottom pb-2 mb-3">ステータス・権限</h6>
            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <label class="form-label">アカウントステータス <span class="text-danger">*</span></label>
                    <select
                        name="account_status_master_id"
                        class="form-select {{ $p['_errorFields']['account_status_master_id'] ?? '' }}"
                        required
                    >
                        <option value="">選択してください</option>
                        @foreach ($accountStatusOptions as $option)
                            <option 
                                value="{{ $option->accountStatusMasterId()->toString() }}"
                                {{ ($p['account_status_master_id'] ?? '') === $option->accountStatusMasterId()->toString() ? 'selected' : '' }}>
                                {{ $option->accountStatusMasterName()->toString() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">メール確認</label>
                    <div class="form-check mt-2">
                        <input
                            type="hidden"
                            name="is_email_verified"
                            value="0"
                        >
                        <input
                            type="checkbox"
                            name="is_email_verified"
                            class="form-check-input"
                            value="1"
                            id="is_email_verified"
                            {{ ($p['is_email_verified'] ?? '') === '1' ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_email_verified">確認済み</label>
                    </div>
                </div>
            </div>

            <h6 class="border-bottom pb-2 mb-3">パスワード管理</h6>
            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <label class="form-label">パスワード変更日時 <span class="text-danger">*</span></label>
                    <input
                        type="datetime-local"
                        name="password_changed_at"
                        class="form-control {{ $p['_errorFields']['password_changed_at'] ?? '' }}"
                        value="{{ $p['password_changed_at'] ?? '' }}"
                        step="1"
                        required
                    >
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">パスワード有効期限 <span class="text-danger">*</span></label>
                    <input
                        type="datetime-local"
                        name="password_expires_at"
                        class="form-control {{ $p['_errorFields']['password_expires_at'] ?? '' }}"
                        value="{{ $p['password_expires_at'] ?? '' }}"
                        step="1"
                        required
                    >
                </div>
            </div>

            <!-- ボタン -->
            <div class="text-center mt-4">
                <a 
                    href="{{ route('admin.admin_account.search.index', [
                        ...request()->query(),
                        'account_id' => request()->route('account_id'), 
                    ]) }}" class="btn btn-secondary px-5"
                >戻る</a>
                <button type="submit" class="btn btn-primary px-5 me-3">確認へ</button>
            </div>
        </form>
    </div>
</div>
@endsection
