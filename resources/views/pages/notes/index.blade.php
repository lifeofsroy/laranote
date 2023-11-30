@extends('layouts.app')
@section('main-section')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="d-none d-sm-block col-auto">
                    <h3><strong>All</strong> Notes</h3>
                </div>

                <div class="mt-n1 col-auto ms-auto text-end">
                    <a class="btn btn-primary" type="button" href="{{ route('user.note.add') }}">Add Note</a>
                </div>
            </div>

            <div class="container-fluid p-0">
                @foreach ($notes as $note)
                    <div class="card" id="noteRow{{ $note->id }}">
                        <div class="card-header pb-1">
                            <a href="{{ route('user.note.show', $note->id) }}">
                                <h4 class="card-title mb-0">{{ $note->title }}</h4>
                            </a>
                            <h6 class="text-info">{{ Carbon\Carbon::parse($note->updated_at)->diffForHumans() }}</h6>
                        </div>
                        <div class="card-body pt-0">
                            <p class="card-text">{{$note->overview}}</p>
                            <div class="mt-2">
                                <a class="card-link" href="{{ route('user.note.edit', $note->id) }}">Edit</a>
                                <a class="card-link" onclick="deleteNote({{ $note->id }})">Delete</a>
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
        // notification
        function notify(msz) {
            let message = msz;
            let type = 'success';
            let duration = 2400;
            let ripple = 1;
            let dismissible = 1;
            let positionX = 'right';
            let positionY = 'top';

            window.notyf.open({
                type,
                message,
                duration,
                ripple,
                dismissible,
                position: {
                    x: positionX,
                    y: positionY
                }
            });
        }

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
