@extends('layouts.install')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>环境检测</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @foreach($messages as $name => $message)
                <div class="row">
                    <div class="col-md-4">{{ $name }}：</div>
                    <div class="col-md-8 text-info">{{ $message }}</div>
                </div>
            @endforeach

        </div>
    </div>
@endsection