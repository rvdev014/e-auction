@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        <span class="alert-close">×</span>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
        <span class="alert-close">×</span>
    </div>
@endif
