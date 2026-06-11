@extends('admin.layouts.admin_main')

@section('title','管理者アカウント 確認')

@section('content')
@php
    $p = method_exists($input, 'getProcessParams') ? $input->getProcessParams()->toArray() : (is_array($input) ? $input : []);
@endphp

<h4>管理者アカウント 確認</h4>
@includeIf('admin.shared.flash')
<form method="post" action="{{ url()->current() }}">
    @csrf
    <input type="hidden" name="_process_key" value="{{ $p['_process_key'] ?? '' }}">

    <table class="table">
        <tr><th>メールアドレス</th><td>{{ $p['email'] ?? '' }}</td></tr>
        <tr><th>名前</th><td>{{ $p['name'] ?? '' }}</td></tr>
        <tr><th>管理者メモ</th><td>{{ $p['admin_note'] ?? '' }}</td></tr>
        <tr><th>アカウント状態</th><td>{{ collect($accountStatusOptions)->firstWhere('id', $p['account_status_master_id'] ?? '')['name'] ?? '' }}</td></tr>
        <tr><th>メール確認済み</th><td>{{ (!empty($p['is_email_verified']) && $p['is_email_verified']!='0') ? 'はい' : 'いいえ' }}</td></tr>
    </table>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">登録する</button>
        <a href="javascript:history.back()" class="btn btn-secondary">入力に戻る</a>
    </div>
</form>
@endsection
