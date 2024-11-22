<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container py-2">
        <a class="navbar-brand font-white fw-bold" href="{{ url('/') }}">
            Traffic Urgency
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    @if (Auth::user()->level == 'Admin')
                        <!-- Tampilkan menu hanya jika tidak berada di halaman root '/' -->
                        @if (!Request::is('/'))
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.index') ? 'fw-bold font-primary nav-active' : '' }}" aria-current="page"
                                    href="{{ route('admin.index') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.new.complaint') ? 'fw-bold font-primary nav-active' : '' }}" aria-current="page"
                                    href="{{ route('admin.new.complaint') }}">Aduan Masuk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.process.complaint') ? 'fw-bold font-primary nav-active' : '' }}" aria-current="page"
                                    href="{{ route('admin.process.complaint') }}">Aduan Ditangani</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.done.complaint') ? 'fw-bold font-primary nav-active' : '' }}" aria-current="page"
                                    href="{{ route('admin.done.complaint') }}">Aduan Selesai</a>
                            </li>
                        @endif
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link btn-login px-4 me-2 mb-3 mb-md-0 mt-5 mt-md-0"
                                href="{{ route('login') }}">Login</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link btn-registrasi px-4" href="{{ route('register') }}">Registrasi</a>
                        </li>
                    @endif
                @else
                    @if (Request::is('/'))
                        <!-- Tampilkan link ke /home jika sudah login dan berada di halaman landing page (/) -->
                        <li class="nav-item">
                            <a class="nav-link btn btnc-primary px-4" href="{{ url('/home') }}">
                                Kembali <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </li>
                    @else
                        <!-- Dropdown menu jika berada di halaman lain -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>
