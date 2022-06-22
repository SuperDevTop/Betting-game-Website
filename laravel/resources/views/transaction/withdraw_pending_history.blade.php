@extends('layouts.app')
@section('css')
<style type="text/css">
    .list_card{
        padding: 30px 20px 20px 20px;
        background-color: rgb(30,30,30);
        margin-top: 20px;
        border-radius: 5px;
    }
    .list_card h3{
        color: white;
    }
    .list_card table th{
        background-color: rgb(40,40,40);
        font-size: 15px;
        color: white;
    }
    .list_card table td{
        color: white;
        font-size: 14px;
    }
    .list_card .filter{
        padding: 10px 0px 20px 0px;
        display: flex;
        justify-content: right;
    }
    .list_card .filter label{
        color: rgb(220,220,220) !important;
        margin: 7px 10px 0px 0px;
    }
    .list_card .filter select{
        background-color: black !important;
        color: white !important;
        width: 200px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="list_card" style="overflow: auto;">
        <h3>Lista de retiradas pendentes</h3>
        <table class="table table-vcenter">
            <thead>
                <tr>
                    <th style="width: 12%;">Encontro</th> <!--  -->
                    <th style="width: 9%;">ID</th> <!--  -->
                    <th style="width: 9%;">Nome</th> <!--  -->
                    <th style="width: 9%;">CPF</th> <!--  -->
                    <th style="width: 9%;">Banco</th> <!--  -->
                    <th style="width: 9%;">Agência</th> <!--  -->
                    <th style="width: 14%;">tipo de conta</th> <!--  -->
                    <th style="width: 9%;">Conta</th> <!--  -->
                    <th style="width: 9%;">Requeridos</th> <!--  -->
                    <th style="width: 10%;">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($withdraws as $withdraw)
                <tr>
                    <td>{{date("Y-m-d", strtotime($withdraw->created_at) - 3600 * 3)}}</td>
                    <td>
                        {{$withdraw->id}} 
                    </td>
                    <td>
                        {{$withdraw->full_name}} 
                    </td>
                    <td>
                        {{$withdraw->cpf}} 
                    </td>
                    <td>
                        {{$withdraw->bank}} 
                    </td>
                    <td>
                        {{$withdraw->agency}} 
                    </td>
                    <td>
                        @if ($withdraw->account_type == "checking_account")
                            Conta Corrente
                        @else 
                            Conta Poupança
                        @endif
                    </td>
                    <td>
                        {{$withdraw->account}} 
                    </td>
                    <td>
                        R$ {{$withdraw->requested_amount}}
                    </td>
                    <td>
                        <a href="{{url('cancel_withdraw/'.$withdraw->id)}}" class="btn btn-primary">Cancelar</a>
                    </td>
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
