@if(session('success'))
    <div style="background:#e6ffed;border:1px solid #c6f6d5;padding:10px;border-radius:6px;margin-bottom:12px;color:#065f46">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#fff1f2;border:1px solid #fecaca;padding:10px;border-radius:6px;margin-bottom:12px;color:#991b1b">
        {{ session('error') }}
    </div>
@endif

@if(session('warning'))
    <div style="background:#fffbeb;border:1px solid #fef3c7;padding:10px;border-radius:6px;margin-bottom:12px;color:#92400e">
        {{ session('warning') }}
    </div>
@endif

@if(session('info'))
    <div style="background:#eff6ff;border:1px solid #bfdbfe;padding:10px;border-radius:6px;margin-bottom:12px;color:#1e3a8a">
        {{ session('info') }}
    </div>
@endif

@if(isset($errors) && $errors->any())
    <div style="background:#fff1f2;border:1px solid #fecaca;padding:10px;border-radius:6px;margin-bottom:12px;color:#991b1b">
        <ul style="margin:0;padding-left:18px">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
