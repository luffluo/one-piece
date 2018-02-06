@extends('layouts.install')

@section('content')
    <div class="ui header">
        <h2>环境检测</h2>
    </div>

    <div class="ui center aligned basic segment">
        <div class="ui grid">
            @foreach($messages as $name => $message)
                <div class="four wide column">
                    <div class="ui medium header">
                        {{ $name }}：
                    </div>
                </div>
                <div class="twelve wide column">{{ $message }}</div>
            @endforeach
        </div>
    </div>
@endsection