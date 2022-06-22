@extends('layouts.app')
@section('css')
<style type="text/css">
    .success_card{
        background-color: rgb(30,30,30);
        border-radius: 5px;
        padding: 50px 20px 50px 30px;
        margin: 30px;
        text-align: center;
    }
    .success_card h1,p{
        color: white;
    }
    .bold{
        font-weight: bold;
    }
</style>
@endsection

@section('content')

<div class="container">
    <div class="success_card">
        <i class="si si-close fa-2x" style="color:#82b54b; font-size: 100px;"></i>
        <h1 class="bold">erro</h1>
        <p>VAlgum erro desconhecido está surgindo. Por favor, tente novamente..</p>
        <a href="{{url('deposit')}}" class="btn btn-primary">Deposite mais</a>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    
</script>
@endsection
