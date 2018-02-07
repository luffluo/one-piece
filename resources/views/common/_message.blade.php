@if (session('status'))
    <div class="ui success message">
        <i class="close icon"></i>
        <div class="header">{{ session('status') }}</div>
    </div>
@endif

@if (session('message'))
    <div class="ui info message">
        <i class="close icon"></i>
        <div class="header">{{ session('message') }}</div>
    </div>
@endif

@if (session('success'))
    <div class="ui success message">
        <i class="close icon"></i>
        <div class="header">{{ session('success') }}</div>
    </div>
@endif

@if (session('danger'))
    <div class="ui danger message">
        <i class="close icon"></i>
        <div class="header">{{ session('danger') }}</div>
    </div>
@endif