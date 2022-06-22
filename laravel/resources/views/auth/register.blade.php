

<!doctype html>

<html lang="en">

    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">



        <title>{{ config('app.name', 'Laravel') }}</title>



        <link rel="icon" href="{{asset('front-assets/img/ico_game.png')}}">



        <meta property="og:type" content="website">

        <meta property="og:url" content="">

        <meta property="og:image" content="">



        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">

        <link rel="stylesheet" id="css-main" href="{{asset('admin-assets/theme/css/dashmix.min.css')}}">



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



                <!-- Page Content -->

                <div class="row no-gutters justify-content-center bg-body-dark" style="background-image: url(/img/forms_bg.png); background-position: center bottom; background-size: cover;">

                    <div class="hero-static col-sm-10 col-md-8 col-xl-6 d-flex align-items-center p-2 px-sm-0">

                        <!-- Sign Up Block -->

                        <h1 style="color: #fff;font-size: 1.5rem;position: absolute;width: 336px;margin-top: -550px;left: 50%;margin-left: -150px;text-align: center;"><img src="/img/ico_azul.png" style="width: 60px;margin: 0 20px 0 -60px;">CADASTRO</h1>

                        <div class="block block-rounded block-transparent block-fx-pop w-100 mb-0 overflow-hidden bg-image" style="background-image: url(front-assets/assets/images/Base_banner.png); box-shadow: 0 0.5rem 2rem #444444; width: 340px !important; margin: 0px auto;">

                            <div class="row no-gutters">

                                <div class="col-md-6 order-md-1 bg-white" style="max-width: 100% !important; flex: 100% !important; background-color: #333 !important; color: #FFF;">

                                    <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6" style="padding-top: 40px !important; padding-bottom: 5px !important;

">

                                        <!-- Header -->

                                        <!--div class="mb-2 text-center">

                                            <p class="text-uppercase font-w700 font-size-sm text-muted">crie sua conta</p>

                                        </div-->

                                        <!-- END Header -->



                                        <form action="{{ route('register') }}" method="POST">

                                            @csrf

                                            <input name="id" value="{{isset($id)?$id:0}}" hidden>

                                            <div class="form-group">

                                                <input type="text" class="form-control form-control-alt" name="full_name" value="{{ old('full_name') }}" placeholder="nome completo">

                                                @if ($errors->any())

                                                    <span class="invalid-error">

                                                        {{ $errors->first('full_name') }}

                                                    </span>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <input type="text" class="form-control form-control-alt" name="email" value="{{ old('email') }}" placeholder="E-mail">

                                                @if ($errors->any())

                                                    <span class="invalid-error">

                                                        {{ $errors->first('email') }}

                                                    </span>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <input type="text" class="form-control form-control-alt" name="phone" value="{{ old('phone') }}" placeholder="telefone">

                                                @if ($errors->any())

                                                    <span class="invalid-error">

                                                        {{ $errors->first('phone') }}

                                                    </span>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <input type="password" class="form-control form-control-alt" name="password" placeholder="senha">

                                                @if ($errors->any())

                                                    <span class="invalid-error">

                                                        {{ $errors->first('password') }}

                                                    </span>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <input type="password" class="form-control form-control-alt" name="password_confirmation" placeholder="Confirmação Da Senha">

                                            </div>

                                            <div class="form-group">

                                                <a href="#" data-toggle="modal" data-target="#modal-terms" style="color: #FFF;">Termos &amp; Condições</a>

                                                <div class="custom-control custom-checkbox custom-control-primary">

                                                    <input type="checkbox" class="custom-control-input" id="signup-terms" name="terms" @if(old('terms')) checked="" @endif>

                                                    <label class="custom-control-label" for="signup-terms">Concordo</label>

                                                    @if ($errors->any())

                                                        <span class="invalid-error">

                                                            {{ $errors->first('terms') }}

                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <button type="submit" class="btn btn-block btn-hero-success" style="background-image: linear-gradient(0deg,#283D71,#466DA5);">

                                                    <i class="fa fa-fw fa-plus mr-1"></i> registro

                                                </button>

                                                <p style="margin:10px 0px 0px 0px; text-align: center;"><a href="{{url('/login')}}" style="margin-bottom: 0px; color: #FFF;">Volte ao login</a></p>

                                            </div>

                                        </form>

                                        <!-- END Sign Up Form -->

                                    </div>

                                </div>

                                <div class="col-md-6 order-md-0 bg-xeco-op d-flex align-items-center" style="display: none !important;">

                                    <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">

                                        <div class="media">

                                            <a class="img-link mr-3" href="{{url('/')}}">

                                                <img class="img-avatar img-avatar-thumb" src="{{asset('front-assets/assets/images/logomr.png')}}" alt="">

                                            </a>

                                            <div class="media-body">

                                                <p class="text-white font-w600 mb-1">

                                                    Registre-se no sistema de apostas crash game.

                                                </p>

                                                <a class="text-white-75 font-w600" href="javascript:void(0)">Million Rocket</a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- END Sign Up Block -->

                    </div>

                </div>

                <!-- END Page Content -->



            </main>

            <!-- END Main Container -->

        </div>

        <!-- END Page Container -->


        

        <script src="{{asset('admin-assets/theme/js/dashmix.core.min.js?v2')}}"></script>



        <script src="{{asset('admin-assets/theme/js/dashmix.app.min.js?v2')}}"></script>



        <!-- Page JS Plugins -->

        <script src="{{asset('admin-assets/theme/js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>



        <!-- Page JS Code -->

        <script src="{{asset('admin-assets/theme/js/pages/op_auth_signup.min.js')}}"></script>

    </body>
</html>

