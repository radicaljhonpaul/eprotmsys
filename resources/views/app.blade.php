<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ePROTrackMoSys</title>

        <!-- Icon -->
        <link rel="icon" href="/images/eprotms_icon.ico" >
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }

            .gradient {
                background: linear-gradient(90deg, #d53369 0%, #daae51 100%);
            }

            /*for mobile responsiveness*/
            @media (max-width: 767px) {
              .navicon {
                width: 1.125em;
                height: .125em;
              }

              .navicon::before,
              .navicon::after {
                display: block;
                position: absolute;
                width: 100%;
                height: 100%;
                transition: all .2s ease-out;
                content: '';
                background: #3D4852;
              }

              .navicon::before {
                top: 5px;
              }

              .navicon::after {
                top: -5px;
              }

              .menu-btn:not(:checked) ~ .menu {
                display: none;
              }

              .menu-btn:checked ~ .menu {
                display: block;
              }

              .menu-btn:checked ~ .menu-icon .navicon {
                background: transparent;
              }

              .menu-btn:checked ~ .menu-icon .navicon::before {
                transform: rotate(-45deg);
              }

              .menu-btn:checked ~ .menu-icon .navicon::after {
                transform: rotate(45deg);
              }

              .menu-btn:checked ~ .menu-icon .navicon::before,
              .menu-btn:checked ~ .menu-icon .navicon::after {
                top: 0;
              }

              .image {
                height: 200px;
                cursor: pointer;
                margin: 5px;
                display: inline-block;
              }
              
            }

            /* Toggle A */
            input:checked ~ .dot {
              transform: translateX(100%);
              background-color: #48bb78;
            }

        </style>

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="/js/jquery.min.js"></script>
    </head>
    <body class="leading-normal tracking-normal text-white" style="font-family: 'Nunito', sans-serif;">
        @inertia
    </body>
</html>
