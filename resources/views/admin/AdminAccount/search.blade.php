@extends('admin.layouts.admin_main')

@section('title','管理者アカウント 一覧')

@section('content')
@includeIf('admin.shared.flash')

<h4>管理者アカウント 一覧</h4>

<div class="mb-3">
    <a href="{{ route('admin.admin_account.index', ['account_id' => request()->route('account_id')]) }}" class="btn btn-secondary">リフレッシュ</a>
    <a href="{{ url('/v1/ad/' . request()->route('account_id') . '/admin_account/create') }}" class="btn btn-primary">新規作成</a>
</div>

@if(isset($paginator) && $paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>メール</th>
                <th>名前</th>
                <th>状態</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paginator as $r)
                <tr>
                    <td>{{ $r->id ?? ($r['id'] ?? '') }}</td>
                    <td>{{ $r->email ?? ($r['email'] ?? '') }}</td>
                    <td>{{ $r->name ?? ($r['name'] ?? '') }}</td>
                    <td>{{ $r->account_status_master_name ?? ($r['account_status_master_name'] ?? '') }}</td>
                    <td>
                        <a href="{{ url('/v1/ad/' . request()->route('account_id') . '/admin_account/detail/' . ($r->id ?? ($r['id'] ?? ''))) }}">表示</a>
                        <a href="{{ url('/v1/ad/' . request()->route('account_id') . '/admin_account/edit/' . ($r->id ?? ($r['id'] ?? ''))) }}">編集</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $paginator->withQueryString()->links() }}
    </div>

@elseif(is_iterable($rows))
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>メール</th>
                <th>名前</th>
                <th>状態</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $r)
                <tr>
                    <td>{{ $r->id ?? ($r['id'] ?? '') }}</td>
                    <td>{{ $r->email ?? ($r['email'] ?? '') }}</td>
                    <td>{{ $r->name ?? ($r['name'] ?? '') }}</td>
                    <td>{{ $r->account_status_master_name ?? ($r['account_status_master_name'] ?? '') }}</td>
                    <td>
                        <a href="{{ url('/v1/ad/' . request()->route('account_id') . '/admin_account/detail/' . ($r->id ?? ($r['id'] ?? ''))) }}">表示</a>
                        <a href="{{ url('/v1/ad/' . request()->route('account_id') . '/admin_account/edit/' . ($r->id ?? ($r['id'] ?? ''))) }}">編集</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($meta))
        <div class="mt-3">
            {{-- Render simple pagination using meta --}}
            @php
                $current = $meta['current_page'] ?? 1;
                $last = $meta['last_page'] ?? 1;
            @endphp
            <nav>
                <ul class="pagination">
                    @for($page = 1; $page <= $last; $page++)
                        <li class="page-item {{ $page == $current ? 'active' : '' }}">
                            <a class="page-link" href="{{ request()->url() . '?' . http_build_query(array_merge(request()->query(), ['page' => $page])) }}">{{ $page }}</a>
                        </li>
                    @endfor
                </ul>
            </nav>
        </div>
    @endif

@else
    <pre>{{ var_export($rows, true) }}</pre>
@endif

@endsection
