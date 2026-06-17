<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item">
            <a href="{{ url('/v1/ad/' . request()->route('account_id')) }}">Top</a>
        </li>
        <li class="breadcrumb-item">
            <b>ユーザアカウント</b>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.user_account.create.index', [
                'account_id' => request()->route('account_id'),
                '?' => request()->query(),
            ]) }}">新規作成</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.user_account.search.index', [
                'account_id' => request()->route('account_id'),
                '?' => request()->query(),
            ]) }}">検索</a>
        </li>
    @if(request()->route('user_account_id'))
        <li class="breadcrumb-item">
            <a href="{{ route('admin.user_account.detail.index', [
                'account_id' => request()->route('account_id'),
                'user_account_id' => request()->route('user_account_id'),
                '?' => request()->query(),
            ]) }}">詳細</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.user_account.edit.index', [
                'account_id' => request()->route('account_id'),
                'user_account_id' => request()->route('user_account_id'),
                '?' => request()->query(),
            ]) }}">更新</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.user_account.create.copy', [
                'account_id' => request()->route('account_id'),
                'user_account_id' => request()->route('user_account_id'),
                '?' => request()->query(),
            ]) }}">複製</a>
        </li>
        <li class="breadcrumb-item">
            <form method="POST"
                action="{{ route(
                    'admin.user_account.delete.index',
                    array_merge(
                        request()->query(),
                        [
                            'account_id' => request()->route('account_id'),
                            'user_account_id' => request()->route('user_account_id'),
                        ]
                    )
                ) }}"
                class="d-inline"
            >
                @csrf
                @method('POST')
            </form>
            <a href="#" onclick="if (confirm('削除しますか？')) { this.previousElementSibling.submit(); } return false;">
                削除
            </a>
        </li>
    @endif
    @if($input?->getInput('id') ?? false)
        <li class="breadcrumb-item">
            <a href="{{ route('admin.user_account.detail.index', [
                'account_id' => request()->route('account_id'),
                'user_account_id' => $input->getInput('id'),
                '?' => request()->query(),
            ]) }}">詳細</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.user_account.edit.index', [
                'account_id' => request()->route('account_id'),
                'user_account_id' => $input->getInput('id'),
                '?' => request()->query(),
            ]) }}">更新</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.user_account.create.copy', [
                'account_id' => request()->route('account_id'),
                'user_account_id' => $input->getInput('id'),
                '?' => request()->query(),
            ]) }}">複製</a>
        </li>
        <li class="breadcrumb-item">
            <form method="POST"
                action="{{ route(
                    'admin.user_account.delete.index',
                    array_merge(
                        request()->query(),
                        [
                            'account_id' => request()->route('account_id'),
                            'user_account_id' => $input->getInput('id'),
                        ]
                    )
                ) }}"
                class="d-inline"
            >
                @csrf
                @method('POST')
            </form>
            <a href="#" onclick="if (confirm('削除しますか？')) { this.previousElementSibling.submit(); } return false;">
                削除
            </a>
        </li>
    @endif
    </ol>
</nav>