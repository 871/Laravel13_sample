@extends('admin.layouts.admin_main')

@section('title','管理者アカウント 詳細')

@section('content')
@includeIf('admin.shared.flash')

<h4>管理者アカウント 詳細</h4>

@if(isset($entity))
    <table class="table">
        <tr><th>ID</th><td>{{ method_exists($entity,'id') ? $entity->id() : ($entity->id ?? '') }}</td></tr>
        <tr><th>メール</th><td>{{ method_exists($entity,'email') ? $entity->email()->toString() : ($entity->email ?? '') }}</td></tr>
        <tr><th>名前</th><td>{{ method_exists($entity,'name') ? $entity->name()->toString() : ($entity->name ?? '') }}</td></tr>
        <tr><th>状態</th><td>{{ method_exists($entity,'accountStatusMasterName') ? $entity->accountStatusMasterName()->toString() : ($entity->account_status_master_name ?? '') }}</td></tr>
        <tr><th>作成日</th><td>{{ $entity->created ?? '' }}</td></tr>
    </table>

    <h5>履歴</h5>
    @if(!empty($histories))
        <ul>
            @foreach($histories as $h)
                <li>{{ is_string($h) ? $h : var_export($h, true) }}</li>
            @endforeach
        </ul>
    @endif
@else
    <p>データが見つかりません。</p>
@endif

@endsection
