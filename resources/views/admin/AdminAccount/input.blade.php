@extends('admin.layouts.admin_main')

@section('title','管理者アカウント 入力')

@section('content')
@php
    $p = method_exists($input, 'getProcessParams') ? $input->getProcessParams()->toArray() : (is_array($input) ? $input : []);
@endphp

<h4>管理者アカウント 入力</h4>
@includeIf('admin.shared.flash')
<form method="post" action="{{ url()->current() }}">
    @csrf
    <input type="hidden" name="_process_key" value="{{ $p['_process_key'] ?? '' }}">

    <div class="mb-3">
        <label class="form-label">メールアドレス</label>
        <input type="email" name="email" class="form-control" value="{{ $p['email'] ?? '' }}">
    </div>

    <div class="mb-3">
        <label class="form-label">パスワード</label>
        <input type="password" name="password" class="form-control" value="">
    </div>

    <div class="mb-3">
        <label class="form-label">名前</label>
        <input type="text" name="name" class="form-control" value="{{ $p['name'] ?? '' }}">
    </div>

    <div class="mb-3">
        <label class="form-label">管理者メモ</label>
        <textarea name="admin_note" class="form-control">{{ $p['admin_note'] ?? '' }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">アカウント状態</label>
        <select name="account_status_master_id" class="form-select">
            <option value="">--</option>
            @foreach(($accountStatusOptions ?? []) as $opt)
                <option value="{{ $opt['id'] ?? $opt[0] ?? '' }}" {{ isset($p['account_status_master_id']) && ($p['account_status_master_id']==($opt['id'] ?? $opt[0] ?? '')) ? 'selected' : '' }}>{{ $opt['name'] ?? ($opt[1] ?? '') }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_email_verified" name="is_email_verified" value="1" {{ (!empty($p['is_email_verified']) && $p['is_email_verified']!='0') ? 'checked' : '' }}>
        <label class="form-check-label" for="is_email_verified">メール確認済み</label>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">確認へ</button>
        <a href="{{ route('admin.admin_account.index', ['account_id' => request()->route('account_id')]) }}" class="btn btn-secondary">一覧へ戻る</a>
    </div>
</form>
@endsection
