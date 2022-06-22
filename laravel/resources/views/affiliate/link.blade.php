@extends('layouts.app')
@section('css')
<style type="text/css">
    .affiliate_card{
        background-color: rgb(30,30,30);
        border-radius: 5px;
        padding: 20px 20px 20px 20px;
        margin-top: 30px;
    }
    .affiliate_card h2,p{
        color: white;
    }
    .bold{
        font-weight: bold;
    }
    input{
        width: 80% !important;
        background-color: black !important;
        color: white !important;
    }
</style>
@endsection

@section('content')

<div class="container">
    <div class="affiliate_card">
        <h2 class="bold">Link de afiliado</h2>
        <p>Este é o seu link de afiliado. Por favor, compartilhe com as pessoas para se registrar para ganhar dinheiro.</p>
        <div style="display: flex; justify-content: left;">
            <input class="form-control" value="{{$affiliate_link}}" id="link" readonly></input>&nbsp;
            <button onclick="myFunction()" class="btn btn-sm btn-secondary" title="clique para copiar">
                &nbsp;<i class="far fa-copy"></i>&nbsp;
            </button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function myFunction() {
      var copyText = document.getElementById("link");
      copyText.select();
      copyText.setSelectionRange(0, 99999); /* For mobile devices */
      navigator.clipboard.writeText(copyText.value);
    }
</script>
@endsection
