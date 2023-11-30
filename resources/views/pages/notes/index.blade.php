@extends('layouts.app')
@section('main-section')
    <nav class="navbar navbar-expand navbar-light navbar-bg">
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>

        <form class="d-sm-inline-block" action="{{ route('user.note.all') }}">
            <div class="input-group input-group-navbar">
                <input class="form-control" name="searchText" type="text" value="{{ request()->query('searchText') }}" aria-label="Search"
                    placeholder="Search…">
                <button class="btn" type="submit">
                    <i class="align-middle" data-feather="search"></i>
                </button>
            </div>
        </form>

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
                <div class="d-none d-sm-block col-auto">
                    <h3><strong>All</strong> Notes</h3>
                </div>

                <div class="mt-n1 col-auto ms-auto text-end">
                    @if (!is_null(request()->query('searchText')))
                        <a class="btn btn-info" type="button" href="{{ route('user.note.all') }}">Clear Search</a>
                    @endif
                    <a class="btn btn-primary" type="button" href="{{ route('user.note.add') }}">Add Note</a>
                </div>
            </div>

            <div class="container-fluid p-0">
                @foreach ($notes as $note)
                    <div class="card" id="noteRow{{ $note->id }}">
                        <div class="card-header pb-1">
                            <a href="{{ route('user.note.show', $note->id) }}">
                                <h4 class="text-secondary mb-0">{{ $note->title }}</h4>
                            </a>
                            <h6 class="text-info">{{ Carbon\Carbon::parse($note->updated_at)->diffForHumans() }}</h6>
                        </div>
                        <div class="card-body pt-0">
                            <p class="card-text">{{ $note->overview }}</p>
                            <div class="mt-2">
                                <a class="card-link text-success" href="{{ route('user.note.show', $note->id) }}">Read</a>
                                <a class="card-link text-warning" href="{{ route('user.note.edit', $note->id) }}">Edit</a>
                                <a class="card-link text-danger" onclick="deleteNote({{ $note->id }})">Delete</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $notes->links() }}
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script>
        // change status
        function changeStatus(id) {
            axios.get(`/user/note/status/${id}`)
                .then((res) => {
                    notify(res.data.message)
                })
                .catch((err) => {
                    console.log(err);
                })
        }

        // delete note
        function deleteNote(id) {
            axios.get(`/user/note/delete/${id}`)
                .then((res) => {
                    // console.log(res);
                    document.querySelector('#noteRow' + res.data.noteid).remove();
                    notify(res.data.message);
                })
                .catch((err) => {
                    console.log(err);
                })
        }
    </script>
@endpush
