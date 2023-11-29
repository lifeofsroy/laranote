<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <form class="d-none d-sm-inline-block">
        <div class="input-group input-group-navbar">
            <input class="form-control" type="text" aria-label="Search" placeholder="Search…">
            <button class="btn" type="button">
                <i class="align-middle" data-feather="search"></i>
            </button>
        </div>
    </form>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            {{-- full screen --}}
            <li class="nav-item">
                <a class="nav-icon js-fullscreen d-none d-lg-block" href="#">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="maximize"></i>
                    </div>
                </a>
            </li>

            @auth
                <li class="nav-item dropdown">
                    <a class="nav-icon" href="{{ route('logout') }}">
                        <div class="position-relative">
                            <i class="align-middle" data-feather="log-out"></i>
                        </div>
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</nav>
