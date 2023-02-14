<div id="bookstore-navbar">
    <nav class="top-nav navbar fixed-top navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            <div>
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    @if (isset($showSearchForm))
                    <li class="form-inline">
                        <form action="{{ route('guest.search') }}" class="form-inline">
                            <input
                                name="query"
                                type="text"
                                placeholder="Search Book"
                                class="form-control"
                                id="search"
                            >
                            <div class="btn-parent">
                                <button type="submit" class="btn btn-secondary">
                                    <i aria-hidden="true" class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </li>
                    @endif
                    <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                    <li class="align-items-center d-flex nav-item text-uppercase">
                        <a class="fw-bold nav-link text-warning" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @endif

                    @if (Route::has('register'))
                    <li class="align-items-center d-flex nav-item text-uppercase">
                        <a class="fw-bold nav-link text-warning" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="fw-bold nav-link text-white dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <a href="{{ route('home') }}" class="dropdown-item">Dashboard</a>

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
</div>
