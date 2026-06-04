<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title','管理エリア')</title>
    <style>
        body{font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Hiragino Kaku Gothic ProN', 'Noto Sans JP', 'Yu Gothic', 'Meiryo', sans-serif; background:#f4f6f8; margin:0}
        .login-wrapper{display:flex;min-height:100vh;align-items:center;justify-content:center}
        .panel{background:#fff;padding:28px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.06);max-width:900px;width:100%}
        header.site-header{margin-bottom:18px}
        footer.site-footer{margin-top:18px;font-size:0.9em;color:#777}
        .container{padding:8px}
        .info{background:#f8f8f8;padding:12px;border-radius:6px}
        a{color:#1a73e8}
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="panel">
            @includeIf('admin._header')

            @includeIf('admin._flash')

            <main class="container">
                @yield('content')
            </main>

            @includeIf('admin._footer')
        </div>
    </div>
</body>
</html>
