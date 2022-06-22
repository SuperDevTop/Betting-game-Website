@extends('admin.layout.default')

@section('content')
    <div class="main-header">
        <div class="sec-page">
          <div class="page-title">
            <h2>Profile Settings</h2>
          </div>
          <div class="page-options">
            <a class="waves-effect waves-set page-opt-dropBtn setWave btn-floating" href="#"><i class="material-icons">perm_data_setting</i></a>
            <a class="waves-effect waves-set page-opt-dropBtn setWave btn-floating" href="#"><i class="material-icons">chat_bubble_outline</i></a>
        </div>
        </div>
        <!-- ============================-->
        <!-- breadcrumb-->
        <!-- ============================-->
        <div class="sec-breadcrumb">
          <nav class="breadcrumbs-nav left">
            <div class="nav-wrapper">
              <div class="col s12">
                <a class="breadcrumb" href="{{ url('admin/') }}">Home</a>
                <a class="breadcrumb" href="#">Profile Setting</a>
              </div>
            </div>
          </nav>
        </div>
    </div>
    <div class="main-container">
        <div class="row" style="margin-top:10px !important;">
            {{--  Flash Message  --}}
            <div class="col s12">
                @include('flash')
            </div>
            {{--  PROFILE UPDATE  --}}
            <form class="col m6 s12 profile-info-form" role="form" method="POST" action="{{ url('/admin/profile/'.auth()->user()->id) }}" enctype="multipart/form-data">
                {{method_field('PUT')}}
                {{ csrf_field() }}
                <div class="card-panel profile-form-cardpanel">
                    <div class="row box-title">
                        <div class="col s12">
                            <h5>Profile Information</h5>
                        </div>
                    </div>
                    <div class="row">
                        {{--   ADMIN USER NAME  --}}
                        <div class="input-field col s12">
                            <i class="material-icons prefix">person</i>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" autofocus>
                            <label for="name">Name</label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        {{--   ADMIN DESIGNATION  --}}
                        <div class="input-field col s12">
                            <i class="material-icons prefix">bookmark</i>
                            <input class="validate" type="text" id="designation" name="designation" value="{{ auth()->user()->designation }}" autofocus>
                            <label for="name">designation</label>
                            @if ($errors->has('designation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('designation') }}</strong>
                                </span>
                            @endif
                        </div>
                        {{--  ADMIN EMAIL  --}}
                        <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input class="validate" type="email" id="email" name="email" value="{{ auth()->user()->email }}" autofocus>
                            <label for="email">Email</label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        {{--  PICTURE  --}}
                        <div class="input-field col s12">
                            <img-fileinput imgsrc="{{ $adminPic }}"></img-fileinput>
                            @if ($errors->has('pic'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pic') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 right-align">
                        <button class="btn waves-effect waves-set" type="submit" name="update_profile">Update<i class="material-icons right">save</i>
                        </button>
                        </div>
                    </div>
                </div>
            </form>
            {{--   CHANGE PASSWORD  --}}
            <form class="col m6 s12 profile-info-form" role="form" method="POST" action="{{ url('/admin/changepassword/'.auth()->user()->id) }}">
                {{method_field('PUT')}}
                {{ csrf_field() }}
                <div class="card-panel profile-form-cardpanel">
                    <div class="row box-title">
                        <div class="col s12">
                            <h5>Change Password</h5>
                        </div>
                    </div>
                    <div class="row">
                        {{--   OLD PASSWORD  --}}
                        <div class="input-field col s12">
                            <input class="validate" type="password" id="oldpassword" name="oldpassword" autofocus>
                            <label for="name">Old Password</label>
                            @if ($errors->has('oldpassword'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('oldpassword') }}</strong>
                                </span>
                            @endif
                        </div>
                        {{--   SET NEW PASSWORD  --}}
                        <div class="input-field col s12">
                            <input class="validate" type="password" id="password" name="password" autofocus>
                            <label for="name">New Password</label>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        {{--   SET NEW PASSWORD  --}}
                        <div class="input-field col s12">
                            <input class="validate" type="password" id="password_confirmation" name="password_confirmation" autofocus>
                            <label for="password_confirmation">Confirm Password</label>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 right-align">
                        <button class="btn waves-effect waves-set" type="submit" name="update_profile">Change Password<i class="material-icons right">save</i>
                        </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
@endsection