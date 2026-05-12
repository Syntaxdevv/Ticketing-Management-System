<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('partials.css')
</head>

<body class="auth-page-wrapper">

    <div class="auth-one-bg position-relative">
        <div class="bg-overlay"></div>

        <div class="auth-page-content">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8">

                        @yield('content')

                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('partials.scripts')
</body>

</html>