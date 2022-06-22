<?php
session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <link rel="icon" href="<?php echo e(asset('front-assets/img/ico_game.png')); ?>">

        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="<?php echo e(asset('admin-assets/theme/css/dashmix.min.css')); ?>">

        <style>
            .invalid-error{
                color:red;
                display:flex;
                margin-top:5px;
            }
        </style>
    </head>
    <body>
       
        <div id="page-container">

            <!-- Main Container -->
            <main id="main-container">

                <div class="bg-image">
                    <div class="row no-gutters justify-content-center bg-primary-dark-op" style="background-image: url(/img/forms_bg.png); background-position: center bottom; background-size: cover;">
                        <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0" style="max-width: 340px !important;">
                            <!-- Sign In Block -->
                            <h1 style="color: #fff;font-size: 1.5rem;position: absolute;width: 336px;margin-top: -400px; text-align: center;"><img src="/img/ico_azul.png" style="width: 60px;margin: 0 20px 0 -60px;">LOGIN</h1>
                            <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden" style="box-shadow: 0 0.5rem 2rem #444444;">
                                <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white" style="max-width: 100% !important; flex: 100% !important; background-color: #333 !important; color: #FFF; padding-top: 40px !important; padding-bottom: 5px !important;">
                                    <!-- Header -->
                                    <!--div class="mb-2 text-center">
                                        <a class="link-fx font-w700 font-size-h1" href="<?php echo e(url('/')); ?>">
                                            <span class="text-dark">Million</span><span class="text-primary">&nbsp;Rocket</span>
                                        </a>
                                        <p class="text-uppercase font-w700 font-size-sm text-muted">Conecte-se</p>
                                    </div-->
                                    <!-- END Header -->

                
                                    <form action="<?php echo e(route('login')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
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
                                                <span class="invalid-error">
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
                                                <span class="invalid-error">
                                                    <?php echo e($errors->first('password')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-left" style="display: block !important; text-align: center !important;">
                                            <div class="custom-control custom-checkbox custom-control-primary">
                                                <input type="checkbox" class="custom-control-input" id="login-remember-me" name="remember" checked>
                                                <label class="custom-control-label" for="login-remember-me">Lembre de mim</label>
                                            </div>
                                            <div class="font-w600 font-size-sm py-1">
                                                <a href="<?php echo e(route('password.request')); ?>" style="color:#fff;">Esqueceu sua senha?</a>
                                            </div>
                                        </div>
                                        <div class="form-group text-center" style="display: block !important; text-align: center !important;">
                                            <button type="submit" class="btn btn-hero-primary" style="background-image: linear-gradient(0deg,#283D71,#466DA5);">
                                                <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Conecte-se
                                            </button>
                                            <p style="margin:10px 0px 0px 0px; text-align: center;">Você não tem conta?<br> <a href="<?php echo e(url('/register')); ?>" style="margin-bottom: 0px; color:#fff;"> Registrar agora.</a></p>
                                        </div>
                                    </form>
                                    <!-- END Sign In Form -->
                                </div>
                            </div>
                            <!-- END Sign In Block -->
                        </div>
                    </div>
                </div>

            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        
        <script src="<?php echo e(asset('admin-assets/theme/js/dashmix.core.min.js?v2')); ?>"></script>

        <script src="<?php echo e(asset('admin-assets/theme/js/dashmix.app.min.js?v2')); ?>"></script>

        <!-- Page JS Plugins -->
        <script src="<?php echo e(asset('admin-assets/theme/js/plugins/jquery-validation/jquery.validate.min.js')); ?>"></script>

        <!-- Page JS Code -->
        <script src="<?php echo e(asset('admin-assets/theme/js/pages/op_auth_signup.min.js')); ?>"></script>
    </body>
</html>
