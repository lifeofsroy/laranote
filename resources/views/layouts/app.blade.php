<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.gstatic.com/" rel="preconnect">
    <link href="{{ asset('assets/user/img/icons/icon-48x48.png') }}" rel="shortcut icon" />

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">

    <meta name="theme-color" content="#6777ef">
    <link href="{{ asset('logo.png') }}" rel="apple-touch-ion">
    <link href="{{ asset('manifest.json') }}" rel="manifest">

    <link href="{{ asset('assets/user/css/light.css') }}" rel="stylesheet">

    <style>
        body {
            opacity: 0;
        }
    </style>
    <script src="https://cdn.tiny.cloud/1/dzqvyjmsaiba40a0vijtidjpk1q82cadxl73m6lse9h8fwr7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    @stack('style')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
        <nav class="sidebar js-sidebar" id="sidebar">
            <div class="sidebar-content js-simplebar">
                <a class='sidebar-brand' href='index.html'>
                    <span class="sidebar-brand-text align-middle">
                        {{ config('app.name') }}
                    </span>
                    <svg class="sidebar-brand-icon align-middle" style="margin-left: -3px" width="32px" height="32px" viewBox="0 0 24 24"
                        fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF">
                        <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                        <path d="M20 12L12 16L4 12"></path>
                        <path d="M20 16L12 20L4 16"></path>
                    </svg>
                </a>

                @include('partials.sidebar')
            </div>
        </nav>

        <div class="main">
            @yield('main-section')
        </div>
    </div>

    <script src="{{ asset('assets/user/js/app.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('sw.js') }}"></script>

    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register('/sw.js')
                .then((reg) => {
                    console.log(reg);
                });
        }
    </script>

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
    </script>
    @stack('script')
</body>

</html>
