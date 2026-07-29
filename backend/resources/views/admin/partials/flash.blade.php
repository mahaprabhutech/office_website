@if(session('success'))
    <div class="alert alert-success" role="status" data-auto-dismiss>
        <span class="alert-icon">@include('admin.partials.icon', ['name' => 'check', 'size' => 18])</span>
        <span>{{ session('success') }}</span>
        <button type="button" data-alert-close aria-label="Close">×</button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" role="alert">
        <span class="alert-icon">@include('admin.partials.icon', ['name' => 'alert', 'size' => 18])</span>
        <span>{{ session('error') }}</span>
        <button type="button" data-alert-close aria-label="Close">×</button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <span class="alert-icon">@include('admin.partials.icon', ['name' => 'alert', 'size' => 18])</span>
        <span>Please correct the highlighted fields and submit again.</span>
        <button type="button" data-alert-close aria-label="Close">×</button>
    </div>
@endif
