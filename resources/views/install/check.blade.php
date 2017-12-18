@extends('layouts.install')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>环境检测</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <dl class="dl-horizontal">
                @foreach($messages as $name => $message)
                    <dt>{{ $name }}：</dt>
                    <dd class="text-info">{{ $message }}</dd>
                @endforeach
            </dl>

        </div>
    </div>
@endsection