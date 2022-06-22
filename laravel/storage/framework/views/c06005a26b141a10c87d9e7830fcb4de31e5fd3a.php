<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

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

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="icon" href="<?php echo e(asset('front-assets/img/ico_game.png')); ?>">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Fonts and Dashmix framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="<?php echo e(asset('admin-assets/theme/css/dashmix.min.css')); ?>">

        <link rel="stylesheet" id="css-main" href="<?php echo e(asset('admin-assets/theme/css/themes/xdream.min.css')); ?>">   
        
        <style type="text/css">
            .error-text{
                color:red;
            }
        </style>

        
    </head>
    <body>
        
        <div id="page-container">

            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="bg-image" style="background-color: grey;">
                    <div class="row no-gutters justify-content-center bg-primary-dark-op">
                        <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                            <!-- Sign In Block -->
                            <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                                <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white">
                                    <!-- Header -->
                                    <div class="mb-2 text-center">
                                        <p class="text-uppercase font-w700 font-size-sm text-muted">Login de administrador</p>
                                    </div>
                                    <!-- END Header -->

                                    
                                    <form action="<?php echo e(url('/admin/login')); ?>" method="POST">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="email" value="<?php echo e(old('email')); ?>" placeholder="E-mail">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user-circle"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php if($errors->any()): ?>
                                                <span class="help-block error-text">
                                                    <?php echo e($errors->first('email')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password" placeholder="senha">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-asterisk"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php if($errors->any()): ?>
                                                <span class="help-block error-text">
                                                    <?php echo e($errors->first('password')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-left">
                                            <div class="custom-control custom-checkbox custom-control-primary">
                                                <input type="checkbox" class="custom-control-input" id="login-remember-me" name="remember" checked>
                                                <label class="custom-control-label" for="login-remember-me">Lembre de mim</label>
                                            </div>
                                            <div class="font-w600 font-size-sm py-1">
                                                <a href="#">Esqueceu sua senha?</a>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-hero-primary">
                                                <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Conecte-se
                                            </button>
                                        </div>
                                    </form>
                                    <!-- END Sign In Form -->
                                </div>
                            </div>
                            <!-- END Sign In Block -->
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        <!--
            Dashmix JS Core

            Vital libraries and plugins used in all pages. You can choose to not include this file if you would like
            to handle those dependencies through webpack. Please check out assets/_es6/main/bootstrap.js for more info.

            If you like, you could also include them separately directly from the assets/js/core folder in the following
            order. That can come in handy if you would like to include a few of them (eg jQuery) from a CDN.

            assets/js/core/jquery.min.js
            assets/js/core/bootstrap.bundle.min.js
            assets/js/core/simplebar.min.js
            assets/js/core/jquery-scrollLock.min.js
            assets/js/core/jquery.appear.min.js
            assets/js/core/js.cookie.min.js
        -->
        <script src="<?php echo e(asset('admin-assets/theme/js/dashmix.core.min.js')); ?>"></script>

        <!--
            Dashmix JS

            Custom functionality including Blocks/Layout API as well as other vital and optional helpers
            webpack is putting everything together at assets/_es6/main/app.js
        -->
        <script src="<?php echo e(asset('admin-assets/theme/js/dashmix.app.min.js')); ?>"></script>

        <!-- Page JS Plugins -->
        <script src="<?php echo e(asset('admin-assets/theme/js/plugins/jquery-validation/jquery.validate.min.js')); ?>"></script>

        <!-- Page JS Code -->
        <script src="<?php echo e(asset('admin-assets/theme/js/pages/op_auth_signin.min.js')); ?>"></script>
    </body>
</html>
