@extends('layouts.app')

@section('css')

<style type="text/css">

    .profile-card{

        margin-top: 30px;

        background-color: rgb(30,30,30);

        padding: 50px 20px 50px 20px;

        color: white;

        border-radius: 5px;

    }

    .profile-card h2{

        color: white;

        font-weight: bold;

        border-bottom: 1px solid white;

        margin-bottom: 50px;

    }

    .profile-card input{

        background-color: black !important;

        color: white !important;

    }

    .error-note{

        color:red;

    }

</style>

@endsection



@section('content')



<div class="container game-container">

    <div class="profile-card">

        <h2>Edit Profile</h2>

        <form autocomplete="off" action="">

            @csrf

            <input autocomplete="false" name="hidden" type="text" style="display:none;">

            <div class="form-group">

                <label>nome</label>

                <?php
                    $full_name = Auth::user()->full_name;

                    if ($errors->any())

                        $full_name = old('full_name');

                ?>

                <input type="text" class="form-control" name="full_name" value="{{ $full_name }}">

                @if ($errors->has('full_name'))

                    <span class="error-note">

                        <strong>{{ $errors->first('full_name') }}</strong>

                    </span>

                @endif

            </div>

            <div class="form-group">

                <label>E-mail</label>

                <?php

                    $email = Auth::user()->email;

                    if ($errors->any())

                        $email = old('email');

                ?>

                <input type="text" class="form-control" name="email" autocomplete="off" value="{{ $email }}">

                @if ($errors->has('email'))

                    <span class="error-note">

                        <strong>{{ $errors->first('email') }}</strong>

                    </span>

                @endif

            </div>

            <div class="form-group">

                <label>telefone</label>

                <?php

                    $phone = Auth::user()->phone;

                    if ($errors->any())

                        $phone = old('phone');

                ?>

                <input type="text" class="form-control form-control-alt" name="phone" value="{{ $phone }}">

                @if ($errors->has('phone'))

                    <span class="error-note">

                        {{ $errors->first('phone') }}

                    </span>

                @endif

            </div>

        </form>

    </div>

</div>

@endsection



@section('js')

<script type="text/javascript">



</script>

@endsection

