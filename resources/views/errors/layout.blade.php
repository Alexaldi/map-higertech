<!doctype html>
<html lang="id" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/brand/logo.png') }}" />

    <title>@yield('title') | Higertech Karya Sinergi</title>

    <!-- BOOTSTRAP CSS -->
    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" />

    <!-- FONT-ICONS CSS -->
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="{{ asset('admin/assets/colors/color1.css') }}" />

    <style>
        .error-page .display-1 {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -2px;
        }
        @media (max-width: 576px) {
            .error-page .display-1 {
                font-size: 5.5rem;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="page">
        <div class="page-content error-page d-flex align-items-center justify-content-center min-vh-100 py-5">
            <div class="container text-center">
                <div class="error-template">
                    <div class="mb-4">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/brand/higertech-logo.png') }}" alt="Higertech Karya Sinergi"
                                style="max-height: 48px; width: auto;" class="img-fluid">
                        </a>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>

</html>
