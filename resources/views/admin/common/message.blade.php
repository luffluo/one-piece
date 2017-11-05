@if (isset($message) && ! empty($message))
    <div class="alert alert-success alert-dismissible fade in" role="alert" style="margin-bottom: 15px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p><strong>提示:</strong></p>
        <p><strong>{{ $message }}</strong></p>
    </div>
@endif

@if (isset($errors) && count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" data-close-time="5" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        @foreach ($errors->all() as $error)
            <p><strong>{{ $error }}</strong></p>
        @endforeach
    </div>
@endif

@section('admin-js-inner')
    @parent
    <script>
        $(function ($) {

            var $closeButton = $('[data-dismiss="alert"]');

            if ($closeButton.length) {
                setTimeout(function () {
                    $closeButton.trigger('click');
                }, 7000);
            }

        });
    </script>
@endsection