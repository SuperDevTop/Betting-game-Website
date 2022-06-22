@extends('layouts.app')
@section('css')
<style type="text/css">
    .block-card{
        margin-top: 30px;
        background-color: rgb(30,30,30);
        padding: 50px 20px 50px 20px;
        color: white;
        border-radius: 5px;
    }
    .block-card h2{
        color: white;
        font-weight: bold;
        border-bottom: 1px solid white;
        margin-bottom: 50px;
    }
    .block-card p{
        font-size: 20px;
        color: red;
    }

</style>
@endsection

@section('content')

<div class="container game-container">
    <div class="block-card">
        <h2>Bloqueado</h2>
        <p>Você não pode fazer nada antes de resolver o problema.<br/>
            Sua conta foi bloqueada. Envie um email para <a href="mailto:onataslenz@gmail.com">jonataslenz@gmail.com</a> para saber qual é o problema.</p>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection
