@extends('layouts.app')

@section('content')
    <div class="diver mt-4 mt-md-5"></div>
    <div class="warp-body">
        <div class="container">
            @include('components.guest.content-1')

            @include('components.guest.content-2')

            @include('components.guest.content-3')

            @include('components.guest.content-4')

            @include('components.guest.content-5')
        </div>
    </div>
@endsection
