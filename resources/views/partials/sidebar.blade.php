<div class="sidebar-user">
    <div class="d-flex justify-content-center">
        <div class="flex-grow-1 ps-2">
            <a class="sidebar-user-title">
                @auth
                    {{ auth()->user()->name }}
                @else
                    Authentication
                @endauth
            </a>
        </div>
    </div>
</div>

@auth
    <ul class="sidebar-nav">
        <li class="sidebar-item {{ Route::is('user.note*') ? 'active' : '' }}">
            <a class="sidebar-link {{ Route::is('user.note*') ? '' : 'collapsed' }}" data-bs-target="#notesss" data-bs-toggle="collapse">
                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Notes</span>
            </a>
            <ul class="sidebar-dropdown list-unstyled {{ Route::is('user.note*') ? 'show' : '' }} collapse" id="notesss" data-bs-parent="#sidebar">
                <li class="sidebar-item {{ Route::is('user.note.all') ? 'active' : '' }}">
                    <a class='sidebar-link' href='{{ route('user.note.all') }}'>All Notes</a>
                </li>
                <li class="sidebar-item {{ Route::is('user.note.add') ? 'active' : '' }}">
                    <a class='sidebar-link' href='{{ route('user.note.add') }}'>Add Note</a>
                </li>
            </ul>
        </li>
    </ul>
@endauth
