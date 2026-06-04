@extends('layouts.admin_login')

@section('title','エラー')

@section('content')
    <div class="info">
        <h3>エラーが発生しました</h3>
        <p>{{ $message ?? '不明なエラーが発生しました。' }}</p>
    </div>
@endsection
