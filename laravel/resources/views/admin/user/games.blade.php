@extends('admin.layout.default')
@section('css')
<link rel="stylesheet" href="{{asset('admin-assets/theme/js/plugins/datatables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('admin-assets/theme/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css')}}">
<style type="text/css">
    .row>div{
        padding-bottom: 5px;
    }

    .total_card{
        margin-top: 30px;
    }
    .total_card .card{
        background-color: white;
        border-radius: 5px;
        padding: 20px 20px 5px 20px;
        margin-bottom: 10px;
    }
    .total_card .card h4{
        
    }
    .bold{
        font-weight: bold;
    }
</style>
@endsection

@section('content')

<?php
    function timeago($date) {
       $timestamp = strtotime($date);   
       
       $strTime = array("segunda", "minuto", "hora", "dia", "mês", "ano");
       $length = array("60","60","24","30","12","10");

       $currentTime = time();
       if($currentTime >= $timestamp) {
            $diff     = time()- $timestamp;
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . $strTime[$i] . "(s) ago ";
       }
    }
?>


<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">jogos do {{$user_name}} usuário</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Gerenciar usuários</li>
                    <li class="breadcrumb-item active" aria-current="page">usuários jogos Lista</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->
<div class="content">
    <!-- Full Table -->

    <div class="total_card">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h4>Apostas totais</h4>
                    <h4 class="bold">{{$user_crash_game_cnt}}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h4>Total de vitórias</h4>
                    <h4 class="bold">{{$user_crash_game_win_cnt}}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h4>Valor total da aposta</h4>
                    <h4 class="bold">R$ {{number_format($user_crash_game_total_amount, 2)}}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h4>Ganhos totais</h4>
                    <h4 class="bold">R$ {{number_format($user_crash_game_total_win_amount, 2)}}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Usuários jogos</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons" id="user-table">
                    <thead>
                        <tr>
                            <th style="width: 12%;">ID do jogo</th>
                            <th style="width: 12%;">Ponto de falha</th>
                            <th style="width: 15%;">hora do acidente</th>
                            <th style="width: 15%;">ponto de aposta</th>
                            <th style="width: 12%;">valor da aposta</th>
                            <th style="width: 12%;">ganho</th>
                            <th style="width: 20%;">encontro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($games as $game) {
                        ?>
                        <tr data-id="{{$game->id}}">
                            <td>
                                {{$game->id}}
                            </td>
                            <td>
                                {{$game->crash_point}}
                            </td>
                            <td>
                                {{$game->crash_time}}s
                            </td>
                            <td>
                                {{$game->user_betting_point}}
                            </td>
                            <td>
                                @if ($game->user_bet_amount == 0)
                                    <span style="color:red;">-</span>
                                @else
                                    R$ {{$game->user_bet_amount}}
                                @endif
                            </td>
                            <td>
                                @if ($game->user_earning == 0)
                                    <span style="color:red;">-</span>
                                @else
                                    R$ {{$game->user_earning}}
                                @endif
                            </td>
                            <td>
                                {{timeago($game->updated_at)}}
                            </td>
                        </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
@endsection

@section('js')

<script src="{{asset('admin-assets/theme/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.colVis.min.js')}}"></script>

<script type="text/javascript">
    $("#user-table").dataTable({
                        language: {
                            searchPlaceholder: "procurar...",
                            info: "Displaying _START_ to _END_ from _TOTAL_ records",
                            paginate: {
                              previous: "anterior",
                              next: "next"
                            }
                        },
                        pageLength: 20,
                        lengthMenu: [
                            [5, 10, 20, 50, 100],
                            [5, 10, 20, 50, 100]
                        ],
                        autoWidth: !1,
                        buttons: [{
                            extend: "copy",
                            className: "btn btn-sm btn-primary"
                        }, {
                            extend: "csv",
                            className: "btn btn-sm btn-primary"
                        }, {
                            extend: "print",
                            className: "btn btn-sm btn-primary"
                        }],
                        dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                    });
</script>
@endsection
