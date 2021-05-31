    <nav class="navbar navbar-light navbar-expand-md navigation-clean">
        <div class="container"><a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if (Route::has('products'))
                        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Artikel&nbsp;<i class="fa fa-tags" style="font-size: 1em;"></i></a>
                            <div class="dropdown-menu"><a class="dropdown-item" href="#">First Item</a><a class="dropdown-item" href="#">Second Item</a><a class="dropdown-item" href="#">Third Item</a></div>
                        </li>
                        @endif
                        @if (Route::has('shopping-cart'))
                            <li class="nav-item d-flex flex-wrap align-items-md-center"><a class="nav-link d-flex flex-wrap" href="{{ route('shopping-cart') }}">{{ __('Warenkorb') }}&nbsp;<i class="fa fa-shopping-cart d-flex flex-wrap justify-content-lg-center align-items-lg-center"></i></a></li>
                        @endif
                        @if (Route::has('products.create'))
                            <li class="nav-item d-flex flex-wrap align-items-md-center"><a class="nav-link d-flex flex-wrap" href="{{ route('products.create') }}">{{ __('Produkte erstellen') }}&nbsp;<i class="fa fa-plus-circle d-flex flex-wrap justify-content-lg-center align-items-lg-center"></i></a></li>
                        @endif
                        @if (Route::has('profile'))
                            <li class="nav-item d-flex flex-wrap align-items-md-center"><a class="nav-link d-flex flex-wrap" href="{{ route('profile') }}">{{ Auth::user()->name }}&nbsp;<i class="fa fa-user-circle-o d-flex flex-wrap justify-content-lg-center align-items-lg-center"></i></a></li>
                        @endif

                        <li class="nav-item d-flex flex-wrap align-items-md-center">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-primary d-lg-flex justify-content-lg-center align-items-lg-center" type="button" style="border-radius: 29px;margin-left: 1em;height: 2em;background: #1a7ae1;border-style: none;">
                                {{ __('Logout') }}
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
