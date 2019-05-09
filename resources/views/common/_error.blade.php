@if(count($errors))
    <div class="page-top ui error message center aligned container" style="width: auto;">
        <i class="close icon"></i>
        <ul class="ui list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif