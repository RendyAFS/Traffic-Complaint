@extends('layouts.app-auth')

@section('content')
    <div class="warp-container">
        <div class="container py-4 d-flex justify-content-center">
            <div class="card card-auth d-none d-lg-block" data-aos="flip-left">
                <div class="d-flex justify-content-beetween">
                    <div class="card-body1 w-50 px-5 py-5">
                        <div class="d-flex flex-column justify-content-center h-100">
                            <h1 class="font-white">Welcome to</h1>
                            <h2 class="font-white">Problem Compliment</h2>
                            <h3 class="mt-4 font-white">Report your complaints here!</h3>
                        </div>
                    </div>
                    <div class="card-body2 w-50 d-flex justify-content-center align-items-center">
                        <div class="form-auth shadow px-5 py-3">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <h2 class="font-primary text-center mb-4">Login</h2>
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <i class="bi bi-person-fill"></i>
                                    </span>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email" aria-describedby="addon-wrapping">
                                </div>

                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Password"
                                        aria-describedby="addon-wrapping">
                                </div>
                                <div class="mb-3 text-center">
                                    <span>Belum punya akun? <a href="/register"
                                            class="fw-bold font-primary text-registrasi">Registrasi</a></span>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btnc-primary fw-bold px-5">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Mobile/Tab --}}
            <div class="card-body2 w-100 d-flex justify-content-center align-items-center d-block d-lg-none"
                data-aos="flip-left">
                <div class="form-auth shadow px-5 py-3">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h2 class="font-primary text-center mb-4">Login</h2>
                        <div class="input-group flex-nowrap mb-3">
                            <span class="input-group-text" id="addon-wrapping">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Email" aria-describedby="addon-wrapping">
                        </div>

                        <div class="input-group flex-nowrap mb-3">
                            <span class="input-group-text" id="addon-wrapping">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Password" aria-describedby="addon-wrapping">
                        </div>
                        <div class="mb-3 text-center">
                            <span>Belum punya akun? <a href="/register"
                                    class="fw-bold font-primary text-registrasi">Registrasi</a></span>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btnc-primary fw-bold px-5">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->has('email') || $errors->has('password'))
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: 'Periksa Kembali Email dan Password',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0D2454'
                });
            @endif
        });
    </script>
@endpush
