@extends('layouts.app')
@section('main-section')
    <nav class="navbar navbar-expand navbar-light navbar-bg">
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav navbar-align">
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

    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="col-auto">
                    <h3>{{ $note->title }}</h3>
                    <h6 class="text-info">{{ Carbon\Carbon::parse($note->updated_at)->format('jS M, y - h:i a') }}</h6>
                </div>

                <div class="mt-n1 col-auto ms-auto text-end">
                    <a class="btn btn-primary" type="button" href="{{ route('user.note.all') }}">Back</a>
                </div>
            </div>

            <div class="container-fluid p-0">
                <div class="card">
                    <div class="card-body">
                        {!! $note->description !!}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
