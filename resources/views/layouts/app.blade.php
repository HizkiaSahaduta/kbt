<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KBT Web Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('outside/assets/img/icon-removebg-preview.png') }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('outside/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('outside/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('outside/assets/css/authentication/form-2.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('outside/assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('outside/assets/css/forms/switches.css') }}">
    <link href="{{ asset('outside/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('outside/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('outside/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('outside/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />

     <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('outside/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('outside/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('outside/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <script src="{{ asset('outside/plugins/sweetalerts/sweetalert2.min.js') }}"></script>

    <style>

        /* body {
        color: #888ea8;
        height: 100%;
        font-size: 0.875rem;
        background-color: #181824;
        background-image: url("https://www.transparenttextures.com/patterns/inspiration-geometry.png");
        background-repeat: revert;
        overflow-x: hidden;
        overflow-y: auto;
        letter-spacing: 0.0312rem;
        font-family: 'Nunito', sans-serif; } */

        .kbt-logo {
                border-radius: 25px;
                background: #fff;
                padding: 9px;
                margin-bottom: 5px;
                height: 35px;
            }

        @media (max-width: 991px) {
            .kbt-logo {
                border-radius: 25px;
                background: #fff;
                padding: 9px;
                margin-bottom: 10px;
                height: 35px;
            }
        }

    </style>

</head>
<body class="form">


    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('outside/assets/js/authentication/form-2.js') }}"></script>


</body>
</html>
