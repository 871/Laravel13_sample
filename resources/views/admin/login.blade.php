@extends('layouts.admin_login')

@section('title','管理ログイン')

@section('content')
    <form method="POST" action="/v1/ad/login" style="max-width:420px;margin:0 auto;">
        @csrf
        <div style="margin-bottom:10px">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px">
        </div>

        <div style="margin-bottom:10px">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px">
        </div>

        <div style="margin-bottom:12px">
            <label style="font-size:0.9em"><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> ログイン情報を保持する</label>
        </div>

        <div style="text-align:center">
            <button type="submit" style="background:#1a73e8;color:#fff;border:none;padding:10px 18px;border-radius:6px;cursor:pointer">ログイン</button>
        </div>

        <p style="margin-top:12px;text-align:center;font-size:0.9em"><a href="/v1/ad/forgot">パスワードをお忘れの方</a></p>
    </form>
@endsection
