@if(session('success'))
    <div class="alert alert-success-custom" onclick="this.style.display='none'">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error-custom" onclick="this.style.display='none'">
        {{ session('error') }}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning-custom" onclick="this.style.display='none'">
        {{ session('warning') }}
    </div>
@endif

@if(session('info'))
    <div class="alert alert-notice" onclick="this.style.display='none'">
    {{ session('info') }}
    </div>
@endif