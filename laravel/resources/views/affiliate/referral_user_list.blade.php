@extends('layouts.app')
@section('css')
<style type="text/css">
    .referral_user_list_card{
        background-color: rgb(30,30,30);
        border-radius: 5px;
        padding: 20px 15px 20px 15px;
        margin-top: 30px;
        overflow: auto;
    }
    .referral_user_list_card table th{
        background-color: rgb(40,40,40);
        font-size: 15px;
        color: white;
    }
    .referral_user_list_card table td{
        color: white;
        font-size: 14px;
    }
    .referral_user_list_card h3,span{
        color: white;
    }
    .bold{
        font-weight: bold;
    }
</style>
@endsection

@section('content')

<div class="container">
    <div class="referral_user_list_card">
        <h3 class="bold">
            Usuários de referência
            <span style="float:right;">{{$referral_users->count()}} Usuários</span>
        </h3>
        <table class="table table-vcenter">
            <thead>
                <tr>
                    <th style="width: 20%;">Nome</th> <!-- Name -->
                    <th style="width: 20%;">E-mail</th> <!-- Email -->
                    <th style="width: 15%;">Equilíbrio</th> <!-- Balance -->
                    <th style="width: 15%;">Status</th> <!-- Status -->
                    <th style="width: 25%;">Registrado em</th> <!-- Registered at -->
                </tr>
            </thead>
            <tbody>
                @foreach ($referral_users as $user)
                <tr>
                    <td>
                        {{$user->full_name}}
                    </td>
                    <td>
                        {{$user->email}}
                    </td>
                    <td>
                        R$ {{$user->balance}}
                    </td>
                    <td>
                        @if ($user->status == "active")
                            <span>{{$user->status}}</span>
                        @else
                            <span style="color:red;">{{$user->status}}</span>
                        @endif
                    </td>
                    <td>{{date("Y-m-d", strtotime($user->created_at) - 3600 * 3)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    
</script>
@endsection
