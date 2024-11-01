@extends('layouts.app')

@section('content')
    <div class="diver mt-4 mt-md-5"></div>
    <div class="warp-body">
        <div class="container">
            @include('components.welcome.content-1')

            @include('components.welcome.content-2')

            @include('components.welcome.content-3')

            @include('components.welcome.content-4')

            @include('components.welcome.content-5')
        </div>
    </div>
@endsection
