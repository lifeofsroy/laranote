@extends('layouts.app')
@section('main-section')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="d-none d-sm-block col-auto">
                    <h3>Login <strong>Or,</strong> Register</h3>
                </div>
            </div>

            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Login</h5>
                                <strong class="checkbox text-success" id="login_success_message"></strong>
                                <strong class="checkbox text-danger" id="login_error_message"></strong>
                            </div>
                            <div class="card-body">
                                <form id="loginForm">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Email</span>
                                            <input class="form-control" name="email" type="text">
                                        </div>
                                        <small class="text-danger" id="login_email_error"></small>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Password</span>
                                            <input class="form-control" name="password" type="password">
                                        </div>
                                        <small class="text-danger" id="login_password_error"></small>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Register</h5>
                                <strong class="checkbox text-success" id="register_success_message"></strong>
                            </div>
                            <div class="card-body">
                                <form id="registerForm">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Name</span>
                                            <input class="form-control" name="name" type="text">
                                        </div>
                                        <small id="register_name_error" class="text-danger"></small>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Email</span>
                                            <input class="form-control" name="email" type="email">
                                        </div>
                                        <small id="register_email_error" class="text-danger"></small>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">New Password</span>
                                            <input class="form-control" name="password" type="password">
                                        </div>
                                        <small id="register_password_error" class="text-danger"></small>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Confirm Password</span>
                                            <input class="form-control" name="password_confirmation" type="password">
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script>
        let csrf_token = document.querySelector('[name="csrf_token"]').content;

        let loginForm = document.querySelector('#loginForm');
        let registerForm = document.querySelector('#registerForm');

        let login_email = loginForm.querySelector('[name="email"]');
        let login_password = loginForm.querySelector('[name="password"]');

        let register_name = registerForm.querySelector('[name="name"]');
        let register_email = registerForm.querySelector('[name="email"]');
        let register_password = registerForm.querySelector('[name="password"]');
        let register_cpassword = registerForm.querySelector('[name="password_confirmation"]');

        let login_email_error = loginForm.querySelector('#login_email_error');
        let login_password_error = loginForm.querySelector('#login_password_error');

        let register_name_error = registerForm.querySelector('#register_name_error');
        let register_email_error = registerForm.querySelector('#register_email_error');
        let register_password_error = registerForm.querySelector('#register_password_error');

        let login_success_message = document.querySelector('#login_success_message');
        let login_error_message = document.querySelector('#login_error_message');

        let register_success_message = document.querySelector('#register_success_message');
    </script>

    <script>
        // user login
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();

            axios.post('{{ route('login.post') }}', {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    email: login_email.value,
                    password: login_password.value,
                })
                .then((res) => {
                    // console.log(res);

                    login_email_error.style.display = 'none';
                    login_password_error.style.display = 'none';

                    if (res.data.success) {
                        login_error_message.style.display = 'none';
                        login_success_message.style.display = 'block';
                        login_success_message.innerText = res.data.success;

                        setTimeout(() => {
                            window.location.replace('{{ route('user.note.all') }}')
                        }, 2000);
                    }

                    if (res.data.error) {
                        login_success_message.style.display = 'none';
                        login_error_message.style.display = 'block';
                        login_error_message.innerText = res.data.error;
                    }
                })
                .catch((err) => {
                    // console.log(err);

                    login_success_message.style.display = 'none';
                    login_error_message.style.display = 'none';

                    if (err.response.data.errors) {
                        err.response.data.errors.email == undefined ?
                            login_email_error.style.display = 'none' : login_email_error.style.display = 'block';
                        login_email_error.innerText = err.response.data.errors.email;

                        err.response.data.errors.password == undefined ?
                            login_password_error.style.display = 'none' : login_password_error.style.display = 'block';
                        login_password_error.innerText = err.response.data.errors.password;
                    }
                })
        });

        // user register
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            axios.post('{{ route('register.post') }}', {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    name: register_name.value,
                    email: register_email.value,
                    password: register_password.value,
                    password_confirmation: register_cpassword.value
                })
                .then((res) => {
                    console.log(res);

                    register_name_error.style.display = 'none';
                    register_email_error.style.display = 'none';
                    register_password_error.style.display = 'none';

                    if (res.data.success) {
                        register_success_message.style.display = 'block';
                        register_success_message.innerText = res.data.success;

                        setTimeout(() => {
                            window.location.replace('{{ route('user.note.all') }}')
                        }, 2000);
                    }
                })
                .catch((err) => {
                    console.log(err);
                    register_success_message.style.display = 'none';

                    if (err.response.data.errors) {
                        err.response.data.errors.name == undefined ?
                            register_name_error.style.display = 'none' : register_name_error.style.display = 'block';
                        register_name_error.innerText = err.response.data.errors.name;

                        err.response.data.errors.email == undefined ?
                            register_email_error.style.display = 'none' : register_email_error.style.display = 'block';
                        register_email_error.innerText = err.response.data.errors.email;

                        err.response.data.errors.password == undefined ?
                            register_password_error.style.display = 'none' : register_password_error.style.display = 'block';
                        register_password_error.innerText = err.response.data.errors.password;
                    }
                })
        })
    </script>
@endpush
