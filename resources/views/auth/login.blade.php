@extends('layouts.app-auth')

@section('content')
    <div class="warp-container">
        <div class="container py-4 d-flex justify-content-center">
            <div class="card w-75">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="card-body1 w-50 px-5 py-3 d-none d-lg-block">
                            <h1>Welcome to</h1>
                            <h2>Problem Complaiment</h2>
                            <h3 class="mt-4">report your complaints here!</h3>
                        </div>
                        <div class="card-body2 w-50 d-flex justify-content-center align-items-center">
                            <div class="form-login shadow px-5 py-3">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <h2 class="font-primary text-center mb-4">Login</h2>
                                    <div class="mb-3">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
