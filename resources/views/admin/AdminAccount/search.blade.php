@extends('admin.layouts.admin_main')

@section('title','管理者アカウント 一覧')

@section('breadcrumb')
    @includeIf('admin.AdminAccount.breadcrumb')
@endsection

@section('content')

<?php

/** @var App\Domain\Admin\AdminAccounts\Entity\AccountStatusMaster[] $accountStatusOptions */

?>
<!-- 検索フォーム -->
<div class="card mb-3">
    <div class="card-header bg-secondary text-white">
        管理者アカウント検索
    </div>
    <div class="card-body">
        <form method="get">
            <input type="hidden" name="sort" value="{{ request('sort') }}">
            <input type="hidden" name="direction" value="{{ request('direction') }}">

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">ID</label>
                    <input
                        type="number"
                        name="id"
                        class="form-control"
                        value="{{ request('id') }}"
                        min="1"
                    >
                </div>
                <div class="col-md-4">
                    <label class="form-label">キーワード（メール/名前）</label>
                    <input
                        type="text"
                        name="keyword"
                        class="form-control"
                        value="{{ request('keyword') }}"
                    >
                </div>
                <div class="col-md-3">
                    <label class="form-label">アカウントステータス</label>
                    <select name="account_status_master_id" class="form-select">
                        <option value="">（全て）</option>
                    @foreach ($accountStatusOptions as $option)
                        <option 
                            value="{{ $option->accountStatusMasterId()->toString() }}" 
                            {{ request('account_status_master_id') === $option->accountStatusMasterId()->toString() ? 'selected' : '' }}
                        >
                            {{ $option->accountStatusMasterName() }}
                        </option>
                    @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">検索</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- 検索結果 -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>検索結果</span>
        <a href="{{ route('admin.admin_account.create.index', [
            'account_id' => request()->route('account_id'),
        ] + request()->query()) }}" class="btn btn-success btn-sm">新規登録</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th>
                        <a href="{{ route('admin.admin_account.search.index', [
                            'account_id' => request()->route('account_id'),
                            'sort' => 'admin_accounts.id',
                            'direction' => request('sort') === 'admin_accounts.id' && request('direction') === 'ASC' ? 'DESC' : 'ASC',
                        ] + request()->query()) }}">ID</a>
                    </th>
                    <th>
                        <a href="{{ route('admin.admin_account.search.index', [
                            'account_id' => request()->route('account_id'),
                            'sort' => 'admin_accounts.email',
                            'direction' => request('sort') === 'admin_accounts.email' && request('direction') === 'ASC' ? 'DESC' : 'ASC',
                        ] + request()->query()) }}">メール</a>
                    </th>
                    <th>
                        <a href="{{ route('admin.admin_account.search.index', [
                            'account_id' => request()->route('account_id'),
                            'sort' => 'admin_accounts.name',
                            'direction' => request('sort') === 'admin_accounts.name' && request('direction') === 'ASC' ? 'DESC' : 'ASC',
                        ] + request()->query()) }}">名前</a>
                    </th>
                    <th>
                        <a href="{{ route('admin.admin_account.search.index', [
                            'account_id' => request()->route('account_id'),
                            'sort' => 'admin_accounts.account_status_master_id',
                            'direction' => request('sort') === 'admin_accounts.account_status_master_id' && request('direction') === 'ASC' ? 'DESC' : 'ASC',
                        ] + request()->query()) }}">ステータス</a>
                    </th>
                    <th>
                        <a href="{{ route('admin.admin_account.search.index', [
                            'account_id' => request()->route('account_id'),
                            'sort' => 'admin_accounts.is_email_verified',
                            'direction' => request('sort') === 'admin_accounts.is_email_verified' && request('direction') === 'ASC' ? 'DESC' : 'ASC',
                        ] + request()->query()) }}">メール確認</a>
                    </th>
                    <th>
                        <a href="{{ route('admin.admin_account.search.index', [
                            'account_id' => request()->route('account_id'),
                            'sort' => 'admin_accounts.password_changed_at',
                            'direction' => request('sort') === 'admin_accounts.password_changed_at' && request('direction') === 'ASC' ? 'DESC' : 'ASC',
                        ] + request()->query()) }}">PW変更日時</a>
                    </th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            @foreach($searchResults['data'] as $row)
                <tr>
                    <td>{{ e($row->id()) }}</td>
                    <td>{{ e($row->email()) }}</td>
                    <td>{{ e($row->name()) }}</td>
                    <td>{{ e($row->accountStatusMasterName()) }}</td>
                    <td>{{ $row->isEmailVerified()->toInt() ? '確認済み' : '未確認' }}</td>
                    <td>{{ e($row->passwordChangedAt()->format('Y/m/d H:i:s')) }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route(
                            'admin.admin_account.detail.index',
                            array_merge(
                                request()->query(),
                                [
                                    'account_id' => request()->route('account_id'),
                                    'admin_account_id' => $row->id()->toString(),
                                ]
                            )
                        ) }}"
                        class="btn btn-info btn-sm">
                            詳細
                        </a>

                        <a href="{{ route(
                            'admin.admin_account.edit.index',
                            array_merge(
                                request()->query(),
                                [
                                    'account_id' => request()->route('account_id'),
                                    'admin_account_id' => $row->id()->toString(),
                                ]
                            )
                        ) }}"
                        class="btn btn-primary btn-sm">
                            更新
                        </a>

                        <a href="{{ route(
                            'admin.admin_account.create.copy',
                            array_merge(
                                request()->query(),
                                [
                                    'account_id' => request()->route('account_id'),
                                    'admin_account_id' => $row->id()->toString(),
                                ]
                            )
                        ) }}"
                        class="btn btn-primary btn-sm">
                            複製
                        </a>

                        <form method="POST"
                            action="{{ route(
                                'admin.admin_account.delete.index',
                                array_merge(
                                    request()->query(),
                                    [
                                        'account_id' => request()->route('account_id'),
                                        'admin_account_id' => $row->id()->toString(),
                                    ]
                                )
                            ) }}"
                            class="d-inline">

                            @csrf
                            @method('POST')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('削除しますか？')">
                                削除
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                全 {{ $searchResults['total'] }} 件中 {{ $searchResults['from'] }}-{{ $searchResults['to'] }} 件
            </div>
            <nav>
                {{-- 前へ --}}
                @php
                    $prev = collect($searchResults['links'])
                        ->first(fn ($link) => str_contains($link['label'], 'Previous'));
                @endphp

                @if($prev && $prev['url'])
                    <a href="{{ $prev['url'] }}">«</a>
                @endif

                {{-- ページ番号 --}}
                @foreach($searchResults['links'] as $link)
                    @continue(str_contains($link['label'], 'Previous'))
                    @continue(str_contains($link['label'], 'Next'))

                    @if($link['active'])
                        <span>{{ $link['label'] }}</span>
                    @else
                        <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                    @endif
                @endforeach

                {{-- 次へ --}}
                @php
                    $next = collect($searchResults['links'])
                        ->first(fn ($link) => str_contains($link['label'], 'Next'));
                @endphp

                @if($next && $next['url'])
                    <a href="{{ $next['url'] }}">»</a>
                @endif
            </nav>
        </div>
    </div>
</div>

@endsection
