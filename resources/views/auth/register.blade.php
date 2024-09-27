@extends('layouts.app-auth')

@section('content')
    <div class="warp-container">
        <div class="container py-4 d-flex justify-content-center">
            <div class="card card-auth d-none d-lg-block" data-aos="flip-right">
                <div class="d-flex justify-content-center">
                    <div class="card-body2 w-50 d-flex justify-content-center align-items-center">
                        <div class="form-auth shadow px-5 py-3">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <h2 class="font-primary text-center mb-4">Registrasi</h2>
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <i class="bi bi-person-fill"></i>
                                    </span>
                                    <input id="name" type="name" class="form-control" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Nama" aria-describedby="addon-wrapping">
                                </div>
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <i class="bi bi-phone-fill"></i>
                                    </span>
                                    <input id="no_hp" type="no_hp" inputmode="numeric" class="form-control"
                                        name="no_hp" value="{{ old('no_hp') }}" required autocomplete="no_hp" autofocus
                                        placeholder="Nomor HP" aria-describedby="addon-wrapping">
                                </div>

                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <i class="bi bi-envelope-at-fill"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email" aria-describedby="addon-wrapping">
                                </div>

                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control" name="password" required
                                        autocomplete="password" autofocus placeholder="Password"
                                        aria-describedby="addon-wrapping">
                                </div>

                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <i class="bi bi-patch-check-fill"></i>
                                    </span>
                                    <input id="password_confirmation" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="password_confirmation" autofocus
                                        placeholder="Konfirmasi Password" aria-describedby="addon-wrapping">
                                </div>
                                <div class="mb-3 text-center">
                                    <span>Sudah punya akun? <a href="/login"
                                            class="fw-bold font-primary text-registrasi">Login</a></span>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btnc-primary fw-bold px-5">
                                        Register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body1 w-50 px-5 py-5">
                        <div class="d-flex flex-column justify-content-center h-100">
                            <h1 class="font-white">Welcome to</h1>
                            <h2 class="font-white">Problem Compliment</h2>
                            <h3 class="mt-4 font-white">Report your complaints here!</h3>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Mobile/Tab --}}
            <div class="card-body2 w-100 d-flex justify-content-center align-items-center d-block d-lg-none"
                data-aos="flip-right">
                <div class="form-auth shadow px-5 py-3">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <h2 class="font-primary text-center mb-4">Registrasi</h2>
                        <div class="input-group flex-nowrap mb-3">
                            <span class="input-group-text" id="addon-wrapping">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input id="name" type="name" class="form-control" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama"
                                aria-describedby="addon-wrapping">
                        </div>
                        <div class="input-group flex-nowrap mb-3">
                            <span class="input-group-text" id="addon-wrapping">
                                <i class="bi bi-phone-fill"></i>
                            </span>
                            <input id="no_hp" type="no_hp" inputmode="numeric" class="form-control"
                                name="no_hp" value="{{ old('no_hp') }}" required autocomplete="no_hp" autofocus
                                placeholder="Nomor HP" aria-describedby="addon-wrapping">
                        </div>

                        <div class="input-group flex-nowrap mb-3">
                            <span class="input-group-text" id="addon-wrapping">
                                <i class="bi bi-envelope-at-fill"></i>
                            </span>
                            <input id="email" type="email" class="form-control" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email"
                                aria-describedby="addon-wrapping">
                        </div>

                        <div class="input-group flex-nowrap mb-3">
                            <span class="input-group-text" id="addon-wrapping">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input id="password" type="password" class="form-control" name="password" required
                                autocomplete="password" autofocus placeholder="Password"
                                aria-describedby="addon-wrapping">
                        </div>

                        <div class="input-group flex-nowrap mb-3">
                            <span class="input-group-text" id="addon-wrapping">
                                <i class="bi bi-patch-check-fill"></i>
                            </span>
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="password_confirmation" autofocus
                                placeholder="Konfirmasi Password" aria-describedby="addon-wrapping">
                        </div>
                        <div class="mb-3 text-center">
                            <span>Sudah punya akun? <a href="/login"
                                    class="fw-bold font-primary text-registrasi">Login</a></span>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btnc-primary fw-bold px-5">
                                Register
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
            @if ($errors->any())
                let errorMessage = '';
                @foreach ($errors->all() as $error)
                    errorMessage += '{{ $error }}\n';
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Periksa kembali data yang Anda masukkan:',
                    html: `<pre style="text-align:left;">${errorMessage}</pre>`,
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endpush
