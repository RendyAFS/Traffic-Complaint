<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container py-2">
        <a class="navbar-brand font-white fw-bold" href="{{ url('/') }}">
            Traffic Complaint
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                @if (Auth::check() && Auth::user()->level == 'Admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.index') ? 'fw-bold font-primary nav-active' : '' }}" aria-current="page"
                            href="{{ route('admin.index') }}">Aduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.done.complaint') ? 'fw-bold font-primary nav-active' : '' }}" aria-current="page"
                            href="{{ route('admin.done.complaint') }}">Aduan Selesai</a>
                    </li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
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
                @endguest
            </ul>
        </div>
    </div>
</nav>
