<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="description" content="">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="">
        <meta property="og:site_name" content="">
        <meta property="og:description" content="">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">


        <link rel="icon" href="{{asset('front-assets/img/ico_game.png')}}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
        

        @yield('css')
        <link rel="stylesheet" id="css-main" href="{{asset('admin-assets/theme/css/dashmix.min.css')}}">
        
        <link rel="stylesheet" id="css-main" href="{{asset('admin-assets/theme/css/themes/xwork.min.css')}}">        
        
        <link rel="stylesheet" href="{{asset('front-assets/css/chat.css')}}">

        <!-- @if (Auth::user()->id != 7)
        <script>
            document.addEventListener('contextmenu', function(e) {
              e.preventDefault();
            });
            document.onkeypress = function (event) {  
                event = (event || window.event);  
                if (event.keyCode == 123) {  
                    return false;  
                }  
            }  
            document.onmousedown = function (event) {  
                event = (event || window.event);  
                if (event.keyCode == 123) {  
                    return false;  
                }  
            }  
            document.onkeydown = function (event) {  
                event = (event || window.event);  
                if (event.keyCode == 123) {  
                    return false;  
                }  
            }  
        </script>
        @endif -->
    </head>
    <body>
        <div id="page-container" style="background-color: #303030;" class="sidebar-o enable-page-overlay side-scroll page-header-fixed page-header-dark main-content-narrow sidebar-dark p-r-300">

            <!-- Sidebar -->
            @include('includes.verticalnav')
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
              @include('includes.header')
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container" style="background-color: #303030;">

                @yield('content')

            </main>
            <!-- END Main Container -->

            <!--@include('includes.chat')-->

            <!-- Footer -->
            
            <!-- END Footer -->
            <!--<div class="chat-button">
                <div class="new-msg-badge" style="display: none;"></div>
                <button class="btn btn-danger" id="chat-button">
                    <i class="fab fa-rocketchat fa-2x"></i>
                </button>
            </div>-->
        </div>
        
        <script src="{{asset('admin-assets/theme/js/dashmix.core.min.js')}}"></script>

        <script src="{{asset('admin-assets/theme/js/dashmix.app.min.js')}}"></script>
        <script src="{{asset('front-assets/js/pusher.min.js')}}"></script>
        <script src="{{asset('front-assets/js/chat.js')}}"></script>
        @yield('js')
    </body>
</html>
