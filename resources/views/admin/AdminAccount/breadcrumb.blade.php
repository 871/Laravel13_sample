<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item">
            <a href="{{ url('/v1/ad/' . request()->route('account_id')) }}">Top</a>
        </li>
        <li class="breadcrumb-item">
            <b>管理者アカウント</b>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.admin_account.create.index', [
                'account_id' => request()->route('account_id'),
                '?' => request()->query(),
            ]) }}">新規作成</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.admin_account.search.index', [
                'account_id' => request()->route('account_id'),
                '?' => request()->query(),
            ]) }}">検索</a>
        </li>
    <?php if (request()->route('admin_account_id')): ?>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.admin_account.detail.index', [
                'account_id' => request()->route('account_id'),
                'admin_account_id' => request()->route('admin_account_id'),
                '?' => request()->query(),
            ]) }}">詳細</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.admin_account.edit.index', [
                'account_id' => request()->route('account_id'),
                'admin_account_id' => request()->route('admin_account_id'),
                '?' => request()->query(),
            ]) }}">更新</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.admin_account.create.copy', [
                'account_id' => request()->route('account_id'),
                'admin_account_id' => request()->route('admin_account_id'),
                '?' => request()->query(),
            ]) }}">複製</a>
        </li>
        <li class="breadcrumb-item">
            {{ Form::open(['route' => ['admin.admin_account.delete.index', 'account_id' => request()->route('account_id'), 'admin_account_id' => request()->route('admin_account_id')], 'method' => 'post', 'onsubmit' => 'return confirm("削除しますか？");']) }}
            {{ Form::submit('削除') }}
            {{ Form::close() }}
        </li>
    <?php endif ?>
    </ol>
</nav>
