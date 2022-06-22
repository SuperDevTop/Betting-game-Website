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
        text-align: right;
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
<div class="container game-container">
    <div class="list_card" style="overflow: auto;">
        <!-- <div class="filter">
            <label>Filter by</label>
            <select class="form-control" id="filter">
                <option value="all">All</option>
                <option value="deposit">deposit</option>
                <option value="withdraw">withdraw</option>
                <option value="affiliate">affiliate</option>
                <option value="earning">earning</option>
            </select>
        </div> -->
        <h3>R$ {{number_format($total_deposit_amount, 2)}}</h3>
        <table class="table table-vcenter">
            <thead>
                <tr>
                    <th style="width: 15%;">Encontro</th> <!-- Date -->
                    <th style="width: 45%;">Descrição</th> <!-- Description -->
                    <th style="width: 10%;">Resultar</th> <!-- Amount -->
                    <th style="width: 15%;">ID da transação</th> <!-- Transaction ID -->
                    <th style="width: 10%;">Status</th> <!-- Status -->
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{date("Y-m-d", strtotime($transaction->created_at) - 3600 * 3)}}</td>
                    <td>
                        Você deposita dinheiro de <span style="color:#ffb119;">{{$transaction->from}}</span> conta de pagamento.
                    </td>
                    <td>
                        R$ {{$transaction->amount}}
                    </td>
                    <td>
                        {{$transaction->transaction_id}}
                    </td>
                    <td>
                        @if ($transaction->status == "pending")
                        <span style="color:#ffb119;">{{$transaction->status}}</span>
                        @else
                            {{$transaction->status}}
                        @endif
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
