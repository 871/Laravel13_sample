<?php


?>
<!-- Sidebar -->
<aside class="sidebar">
    <h6>管理者メニュー</h6>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a
                class="nav-link text-white"
                href="{{ url('/v1/ad/' . request()->route('account_id')) }}"
            >Top</a>
        </li>
    @if(false) {{-- TODO 未実装 --}}
        <li class="nav-item">
            <details 
                class="admin-menu-group" 
                {{ request()->routeIs([
                    'admin.user_account.*',
                    'admin.user_grant.*',
                    'admin.user_grant.role.*',
                ]) ? 'open' : '' }}
            >
                <summary class="nav-link text-white">ユーザ管理</summary>
                <ul class="nav flex-column admin-submenu">
                    <li class="nav-item">
                        <a
                            class="nav-link text-white"
                            href="{{ route('admin.user-account.search.init', [
                                'account_id' => request()->route('account_id'),
                            ]); }}"
                        >ユーザアカウント</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link text-white"
                            href="{{ route('admin.user-agrant.search.init', [
                                'account_id' => request()->route('account_id'),
                            ]); }}"
                        >ユーザ権限</a>
                    </li>
                </ul>
            </details>
        </li>
        <li class="nav-item">
            <details 
                class="admin-menu-group"
                {{ request()->routeIs([
                    'admin.log.login_log.*',
                    'admin.log.page_access_log.*',
                ]) ? 'open' : '' }}
            >
                <summary class="nav-link text-white">ログ管理</summary>
                <ul class="nav flex-column admin-submenu">
                    <li class="nav-item">
                        <a
                            class="nav-link text-white"
                            href="{{ route('admin.log.login-log.search.init', [
                                'account_id' => request()->route('account_id'),
                            ]); }}"
                        >ログイン試行ログ</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link text-white"
                            href="{{ route('admin.log.page-access-log.search.init', [
                                'account_id' => request()->route('account_id'),
                            ]); }}"
                        >ページアクセスログ</a>
                    </li>
                </ul>
            </details>
        </li>
        <li class="nav-item">
            <details 
                class="admin-menu-group"
                {{ request()->routeIs([
                    'admin.mail_manage.*',
                    'admin.admin_account.*',
                    'admin.admin_grant.*',
                    'admin.admin_grant.role.*',
                ]) ? 'open' : '' }}
            >
                <summary class="nav-link text-white">システム管理</summary>
                <ul class="nav flex-column admin-submenu">
                    <li class="nav-item">
                        <a
                            class="nav-link text-white"
                            href="{{ route('admin.mail-manage.search.init', [
                                'account_id' => request()->route('account_id'),
                            ]); }}"
                        >システムメール</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link text-white"
                            href="{{ route('admin.admin-account.search.init', [
                                'account_id' => request()->route('account_id'),
                            ]); }}"
                        >管理者アカウント</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link text-white"
                            href="{{ route('admin.admin-grant.search.init', [
                                'account_id' => request()->route('account_id'),
                            ]); }}"
                        >管理者権限</a>
                    </li>
                </ul>
            </details>
        </li>
    @endif
    </ul>
</aside>
