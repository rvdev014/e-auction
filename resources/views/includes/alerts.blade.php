@if (session()->has('success'))
    <div class="alert alert-success alert-flash">
        {{ session('success') }}
        <span class="alert-close">×</span>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger alert-flash">
        {{ session('error') }}
        <span class="alert-close">×</span>
    </div>
@endif
