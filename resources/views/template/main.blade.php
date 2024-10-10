<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tim Kemenanganan" />
    <meta property="og:title" content="Tim Kemenanganan" />
    <meta property="og:description" content="Tim Kemenanganan" />
    <meta property="og:image" content="{{ asset('') }}assets/images/logoloading.png" />
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>Tim Kemenanganan</title>

    @yield('header')

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('') }}assets/images/logoloading.png" />
    <!-- Custom Stylesheet -->


    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/jquery-nice-select/css/nice-select.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/css/style.css">

</head>

<body>
    @php
        $color = session()->get('color');
        $logo_text = session()->get('logo_text');
        $logo = session()->get('logo');
        // dd($logo);
    @endphp


    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <img src="{{ asset('') }}assets/images/logoloading.png" class="logo-abbr" width="53" height="53"
            viewBox="0 0 53 53"> <br>
        <div class="waviy">
            <span style="--i:1">T</span>
            <span style="--i:2">I</span>
            <span style="--i:3">M</span>
            <span style="--i:4"></span>
            <span style="--i:5">K</span>
            <span style="--i:6">E</span>
            <span style="--i:6">M</span>
            <span style="--i:7">E</span>
            <span style="--i:8">N</span>
            <span style="--i:9">A</span>
            <span style="--i:10">N</span>
            <span style="--i:11">G</span>
            <span style="--i:11">A</span>
            <span style="--i:11">N</span>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        @include('template.navbar')
        <!--**********************************
            Nav header end
        ***********************************-->


        <!--**********************************
            Header start
        ***********************************-->
        @include('template.header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->


        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('template.menu')
        <!--**********************************
            Sidebar end
        ***********************************-->



        <!--**********************************
            Content body start
        ***********************************-->
        @yield('content')
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        @include('template.footer')
        <!--**********************************
            Footer end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('') }}assets/vendor/global/global.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>



    @yield('footer')

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('') }}assets/js/custom.min.js"></script>
    {{-- <script src="{{ asset('') }}assets/js/dlabnav-init.js"></script> --}}

    <script>
        "use strict"

        var dezSettingsOptions = {};

        function getUrlParams(dParam) {
            var dPageURL = window.location.search.substring(1),
                dURLVariables = dPageURL.split('&'),
                dParameterName,
                i;

            for (i = 0; i < dURLVariables.length; i++) {
                dParameterName = dURLVariables[i].split('=');

                if (dParameterName[0] === dParam) {
                    return dParameterName[1] === undefined ? true : decodeURIComponent(dParameterName[1]);
                }
            }
        }

        (function($) {

            "use strict"

            dezSettingsOptions = {
                typography: "cairo",
                version: "light",
                layout: "horizontal",
                primary: "{{ $color }}",
                navheaderBg: "{{ $color }}",
                sidebarBg: "{{ $color }}",
                sidebarStyle: "full",
                sidebarPosition: "fixed",
                headerPosition: "fixed",
                containerLayout: "full",
            };

            new dezSettings(dezSettingsOptions);

            jQuery(window).on('resize', function() {
                /*Check container layout on resize */
                //alert(dezSettingsOptions.primary);
                dezSettingsOptions.containerLayout = $('#container_layout').val();
                /*Check container layout on resize END */

                new dezSettings(dezSettingsOptions);
            });

        })(jQuery);
    </script>




</body>

</html>
