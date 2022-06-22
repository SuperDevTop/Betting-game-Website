<?php $__env->startSection('css'); ?>

<link rel="stylesheet" id="css-main" href="<?php echo e(asset('front-assets/css/crash-game.css')); ?>">

<style type="text/css">



</style>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>



<div class="container game-container">

    <div class="card">

        <div class="row">

            <div class="col-md-7">

                <div class="game-graph" id="game-graph">

                    <canvas id="game" width="1280" height="739"></canvas>

                    <div class="progress" style="display: none;">

                        <div class="bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">

                            <span class="font-size-sm font-w600" style="position: absolute; left: 50%;">5s</span>

                        </div>

                    </div>



                    <div class="playing" style="display: none; opacity: 0.8;">

                        <h3 id="current_point">10.24X</h3>

                    </div>



                    <div class="end" style="display: none;">

                        <h3 id="crash_point">10.24X</h3>

                        <hr style="border-bottom: 1px solid rgb(200,200,200); margin:5px 0px 5px 0px;"></h>

                        <h3>Crashed</h3>

                    </div>



                    <div class="win" style="display: none;">

                        <h5>Você ganha</h5>

                        <hr style="border-bottom: 1px solid rgb(200,200,200); margin:5px 0px 5px 0px;"></h>

                        <h5 id="earning" style="font-size: 17px; font-weight: bold;"></h5>

                    </div>



                </div>

                <div class="border-history-label">

                    <label>HISTÓRIA</label>

                </div>

                <div class="point-history">

                </div>

            </div>

            <div class="col-md-5 border-left-custom">

                <div class="setting">

                    <div class="btn-group option p-b-10 betting_type" role="group" >

                        <button type="button" class="btn btn-outline-primary active" id="normal">Normal</button>

                        <button type="button" class="btn btn-outline-primary" id="auto">Auto</button>

                    </div>

                    <div class="input-group p-b-10 quantity">

                        <input type="number" class="form-control form-control-alt" id="quantity" placeholder="Quantia">

                        <div class="input-group-append">

                            <span class="input-group-text input-group-text-alt">

                                R$

                            </span>

                            <button type="button" id="half" class="btn btn-outline-primary">

                                1/2

                            </button>

                            <button type="button" id="double" class="btn btn-outline-primary">

                                2x

                            </button>

                        </div>

                    </div>

                    <div class="input-group p-b-10">

                        <input type="number" class="form-control" id="betting_point" placeholder="Auto Retirar">

                    </div>

                    <div class="input-group p-b-10 total_auto" style="display: none;">

                        <input type="number" class="form-control" id="total_auto" placeholder="Total apostas" value="5">

                        <div class="input-group-append">

                            <span class="input-group-text input-group-text-alt">

                                <i class="fa fa-infinity"></i>

                            </span>

                        </div>

                    </div>

                    <div class="button" id="button">

                        <button type="button" class="btn btn-hero-danger button" id="place_bet_next_round" style="display: none;">Faça uma aposta na próxima rodada</button>

                        <button type="button" class="btn btn-hero-danger button" id="place_bet" style="display: none;">Fazer uma aposta</button>

                        <button type="button" class="btn btn-hero-secondary button" disabled id="button_status" style="display: none;">Você colocou</button>

                        <button type="button" class="btn btn-hero-danger button" id="get" style="display: none;">aposte agora</button>



                        <button type="button" class="btn btn-hero-danger button" id="start_auto_betting" style="display: none;">Iniciar apostas automáticas</button>

                        <button type="button" class="btn btn-hero-danger button" id="stop_auto_betting" style="display: none;">Pare de apostas automáticas</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="play_list">

        <h5>

            <span id="user_count">0</span> jogadores fizeram suas apostas

            <span id="total_amount">R$0</span>

        </h5>

        <table class="table table-vcenter">

            <thead>

                <tr>

                    <th style="width: 40%;">Usuário</th>

                    <th style="width: 20%;">Aposta</th>

                    <th style="width: 20%;">Multiplicador</th>

                    <th style="width: 20%;">Lucro</th>

                </tr>

            </thead>

            <tbody>



            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>

<script src="<?php echo e(asset('front-assets/js/crash-game-component.js')); ?>"></script>

<script src="<?php echo e(asset('front-assets/plugin/css-element-queries/src/ResizeSensor.js')); ?>"></script>

<script src="<?php echo e(asset('front-assets/plugin/css-element-queries/src/ElementQueries.js')); ?>"></script>

<script src="<?php echo e(asset('admin-assets/theme/js/plugins/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>

<script src="<?php echo e(asset('front-assets/js/crash-game.js')); ?>"></script>

<script type="text/javascript"></script>

<!-- Start of rms4682 Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=e2a8e8c5-0267-4354-b4a7-a99e5535304d"> </script>
<!-- End of rms4682 Zendesk Widget script -->

<script>  
$.post("/transacoes/sessao.php",{email:'<?php echo e(Auth::user()->email); ?>'}, function(data){
    console.log(data);
});
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>