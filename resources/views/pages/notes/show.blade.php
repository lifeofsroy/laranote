@extends('layouts.app')
@section('main-section')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="d-none d-sm-block col-auto">
                    <h3>{{ $note->title }}</h3>
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
