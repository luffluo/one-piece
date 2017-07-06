@extends('install.layout')

@section('content')
    <div class="page-header">
        <h1 class="text-center text-success">环境检测</h1>
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