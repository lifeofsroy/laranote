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
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Title</th>
                            <th>Activate</th>
                            <th>Modified</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notes as $note)
                            <tr id="noteRow{{ $note->id }}">
                                <td>
                                    {{ ($notes->currentpage() - 1) * $notes->perpage() + $loop->index + 1 }}
                                </td>

                                <td>{{ $note->title }}</td>

                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckChecked" type="checkbox"
                                            {{ $note->is_active == 1 ? 'checked' : '' }} onchange="changeStatus({{ $note->id }})">
                                    </div>
                                </td>

                                <td>
                                    {{ Carbon\Carbon::parse($note->updated_at)->diffForHumans() }}
                                </td>

                                <td class="table-action text-center">
                                    <a class="text-warning mx-2" href="{{ route('user.note.show', $note->id) }}">
                                        <i class="align-middle" data-feather="eye"></i>
                                    </a>

                                    <a class="text-info mx-2" href="{{ route('user.note.edit', $note->id) }}">
                                        <i class="align-middle" data-feather="edit"></i>
                                    </a>

                                    <a class="text-danger mx-2" onclick="deleteNote({{ $note->id }})">
                                        <i class="align-middle" data-feather="trash-2"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
