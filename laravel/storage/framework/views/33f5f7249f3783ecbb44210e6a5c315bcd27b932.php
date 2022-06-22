<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

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


        <link rel="icon" href="<?php echo e(asset('front-assets/img/ico_game.png')); ?>">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
        

        <?php echo $__env->yieldContent('css'); ?>
        <link rel="stylesheet" id="css-main" href="<?php echo e(asset('admin-assets/theme/css/dashmix.min.css')); ?>">
        
        <link rel="stylesheet" id="css-main" href="<?php echo e(asset('admin-assets/theme/css/themes/xwork.min.css')); ?>">        
        
        <link rel="stylesheet" href="<?php echo e(asset('front-assets/css/chat.css')); ?>">

        <!-- <?php if(Auth::user()->id != 7): ?>
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
        <?php endif; ?> -->
    </head>
    <body>
        <div id="page-container" style="background-color: #303030;" class="sidebar-o enable-page-overlay side-scroll page-header-fixed page-header-dark main-content-narrow sidebar-dark p-r-300">

            <!-- Sidebar -->
            <?php echo $__env->make('includes.verticalnav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
              <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container" style="background-color: #303030;">

                <?php echo $__env->yieldContent('content'); ?>

            </main>
            <!-- END Main Container -->

            <!--<?php echo $__env->make('includes.chat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>-->

            <!-- Footer -->
            
            <!-- END Footer -->
            <!--<div class="chat-button">
                <div class="new-msg-badge" style="display: none;"></div>
                <button class="btn btn-danger" id="chat-button">
                    <i class="fab fa-rocketchat fa-2x"></i>
                </button>
            </div>-->
        </div>
        
        <script src="<?php echo e(asset('admin-assets/theme/js/dashmix.core.min.js')); ?>"></script>

        <script src="<?php echo e(asset('admin-assets/theme/js/dashmix.app.min.js')); ?>"></script>
        <script src="<?php echo e(asset('front-assets/js/pusher.min.js')); ?>"></script>
        <script src="<?php echo e(asset('front-assets/js/chat.js')); ?>"></script>
        <?php echo $__env->yieldContent('js'); ?>
    </body>
</html>
