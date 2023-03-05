
<nav class="navbar navbar-dark navbar-expand-lg nav-bg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Multipe Todo List</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            @if (Session::has('user'))
            <li class="nav navbar-nav navbar-right">
             <a class="nav-link"  href="{{ route('logout') }}">Logout</a>
            </li>
            @else
       
                <li class="nav navbar-nav navbar-right">
                    <a class="nav-link {{(Route::current()->uri() == 'login') ? 'active' : '' }}"  href="{{ url('/login') }}">Login</a>
                </li>
                <li class="nav navbar-nav navbar-right">
                    <a class="nav-link {{(Route::current()->uri() == 'register') ? 'active' : '' }}" href="{{url('/register')}}">Register </a>

                </li>
            @endif
        </div>
    </div>
</nav>

