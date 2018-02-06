@if (isset($message) && ! empty($message))
    <div class="ui success message" role="alert">
        <i class="close icon"> </i>
        <p>{{ $message }}</p>
    </div>
@endif

@if (isset($errors) && count($errors) > 0)
    <div class="ui error message" role="alert">
        <i class="close icon"></i>
        <ul class="list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('admin-js-inner')
    @parent
    <script>
        $(function () {

            $('.message .close').on('click', function() {
                $(this).closest('.message').transition('fade');
            });

            var $closeButton = $('[class=close]');
            if ($closeButton.length) {
                setTimeout(function () {
                    $('.message .close').closest('.message').transition('fade');
                }, 5000);
            }

        });
    </script>
@endsection