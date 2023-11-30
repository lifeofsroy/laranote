@extends('layouts.app')
@section('main-section')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="d-none d-sm-block col-auto">
                    <h3><strong>Add</strong> Note</h3>
                </div>

                <div class="mt-n1 col-auto ms-auto text-end">
                    <a class="btn btn-primary" type="button" href="{{ route('user.note.all') }}">Back</a>
                </div>
            </div>

            <div class="container-fluid p-0">
                <div class="card">
                    <div class="card-body">
                        <form id="addNoteForm">
                            <div class="mb-3">
                                <label class="form-label" for="title">Title</label>
                                <textarea class="form-control" name="title" id="title" rows="3"></textarea>
                                <small class="text-danger" id="title_error"></small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="overview">Overview</label>
                                <textarea class="form-control" name="overview" id="overview" rows="3"></textarea>
                                <small class="text-danger" id="overview_error"></small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="10"></textarea>
                                <small class="text-danger" id="description_error"></small>
                            </div>

                            <button class="btn btn-primary" type="submit">Create Note</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', () => {
            let csrf_token = document.querySelector('[name="csrf_token"]').content;
            let ckdesc = document.querySelector('#description');
            let addNoteForm = document.querySelector('#addNoteForm');
            let title = addNoteForm.querySelector('[name="title"]');
            let overview = addNoteForm.querySelector('[name="overview"]');
            let description = addNoteForm.querySelector('[name="description"]');
            let title_error = addNoteForm.querySelector('#title_error');
            let overview_error = addNoteForm.querySelector('#overview_error');
            let description_error = addNoteForm.querySelector('#description_error');
            let desc;

            // ckeditor
            ClassicEditor.create(ckdesc)
                .catch(err => {
                    console.log(err);
                })

            // form submision
            addNoteForm.addEventListener('submit', (e) => {
                e.preventDefault();

                axios.post('{{ route('user.note.create') }}', {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrf_token,
                        },
                        title: title.value,
                        overview: overview.value,
                        description: description.value,
                    })
                    .then((res) => {
                        // console.log(res);
                        title_error.style.display = 'none';
                        overview_error.style.display = 'none';
                        description_error.style.display = 'none';

                        notify(res.data.message);

                        setTimeout(() => {
                            window.location.replace('{{ route('user.note.all') }}')
                        }, 2000);
                    })
                    .catch((err) => {
                        // console.log(err);
                        if (err.response.data.errors) {
                            err.response.data.errors.title == undefined ? title_error.style.display = 'none' : title_error.style
                                .display =
                                'block';

                            err.response.data.errors.overview == undefined ? overview_error.style.display = 'none' : overview_error.style
                                .display =
                                'block';

                            err.response.data.errors.description == undefined ? description_error.style.display = 'none' :
                                description_error.style
                                .display =
                                'block';

                            title_error.innerText = err.response.data.errors.title;
                            overview_error.innerText = err.response.data.errors.overview;
                            description_error.innerText = err.response.data.errors.description;
                        }
                    })
            })

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

        })
    </script>
@endpush
