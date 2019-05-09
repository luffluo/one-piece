@if (session('status'))
    <div class="page-top ui success message">
        <i class="close icon"></i>
        <div class="ui center aligned header">{{ session('status') }}</div>
    </div>
@endif

@if (session('message'))
    <div class="page-top ui info message">
        <i class="close icon"></i>
        <div class="ui center aligned header">{{ session('message') }}</div>
    </div>
@endif

@if (session('success'))
    <div class="page-top ui success message">
        <i class="close icon"></i>
        <div class="ui center aligned header">{{ session('success') }}</div>
    </div>
@endif

@if (session('danger'))
    <div class="page-top ui danger message">
        <i class="close icon"></i>
        <div class="ui center aligned header">{{ session('danger') }}</div>
    </div>
@endif