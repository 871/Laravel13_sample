<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>@yield('title','管理画面')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- noUiSlider CSS -->
<link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css" rel="stylesheet">

<link href="/v1/ad/css/lyaout.css" rel="stylesheet">

<!-- jQuery（Select2は必要） -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- noUiSlider JS -->
<script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js"></script>
</head>
<body>

<header>
    <h5 class="mb-0">管理画面</h5>
    <!-- Header Menu -->
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <form 
                method="POST" 
                action="{{ url('/v1/ad/' . request()->route('account_id') . '/logout') }}"
                onsubmit="return confirm('ログアウトしますか？')"
            >
                @csrf
                <button type="submit">ログアウト</button>
            </form>
        </li>
    </ul>
</header>

<div class="wrapper">
    @includeIf('admin.shared.left_menu')
    <!-- Main Content -->
    <main class="main-content">
        @yield('breadcrumb')
        <!-- Message Area -->
        <div class="message-area mb-3">
            @includeIf('admin.shared.flash')
        </div>
        <div class="mb-3">
            @yield('content')
        </div>
    </main>
</div>

<!-- Footer (Full Width) -->
<footer>
    © 2026 Admin System
</footer>

</body>
</html>
