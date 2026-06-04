<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
    <div style="display:flex;align-items:center;gap:12px">
        <a href="/v1/ad" style="text-decoration:none;color:inherit"><strong>管理パネル</strong></a>
        <nav style="font-size:0.9em;color:#555">
            <a href="/v1/ad" style="margin-right:8px">ダッシュボード</a>
            <a href="/v1/ad/accounts" style="margin-right:8px">アカウント</a>
            <a href="/v1/ad/settings">設定</a>
        </nav>
    </div>
    <div style="font-size:0.9em;color:#555">
        @if(Auth::check())
            ようこそ、{{ Auth::user()->name ?? Auth::user()->email }} | <a href="/logout">ログアウト</a>
        @elseif(session('admin_user'))
            ようこそ、{{ session('admin_user.name') ?? session('admin_user.email') }} | <a href="/v1/ad/" onclick="event.preventDefault();document.getElementById('logout-form').submit();">ログアウト</a>
            <form id="logout-form" action="/v1/ad/{{ session('admin_user.id') }}/logout" method="post" style="display:none">@csrf</form>
        @else
            <a href="/v1/ad/login">ログイン</a>
        @endif
    </div>
</div>