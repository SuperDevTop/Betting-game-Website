
<?php $__env->startSection('css'); ?>
<style type="text/css">
    .list_card{
        padding: 20px 20px 20px 20px;
        background-color: rgb(30,30,30);
        margin-top: 20px;
    }
    .list_card table{
        
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
    .total_card{
        margin-top: 30px;
    }
    .total_card .card{
        background-color: rgb(30,30,30);
        border-radius: 5px;
        padding: 20px 20px 5px 20px;
        margin-bottom: 10px;
    }
    .total_card .card h4{
        color: white;
    }
    .bold{
        font-weight: bold;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

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

<div class="container game-container">
    <div class="total_card">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h4>total de apostas</h4>
                    <h4 class="bold"><?php echo e($total_bet_count); ?></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h4>total de vitórias</h4>
                    <h4 class="bold"><?php echo e($total_bet_win); ?></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h4>Valor total da aposta</h4>
                    <h4 class="bold">R$ <?php echo e(number_format($total_bet_amount, 2)); ?></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h4>Ganhos totais</h4>
                    <h4 class="bold">R$ <?php echo e(number_format($total_earning, 2)); ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="list_card" style="overflow: auto;">
        <table class="table table-vcenter">
            <thead>
                <tr>
                    <th style="width: 15%;">ID do jogo</th>
                    <th style="width: 12%;">Ponto de falha</th>
                    <th style="width: 12%;">Tempo de falha</th>
                    <th style="width: 15%;">Valor da aposta</th>
                    <th style="width: 12%;">Valor da aposta</th>
                    <th style="width: 12%;">Ganho</th>
                    <th style="width: 20%;">Tempo atrás</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($game->game_id); ?></td>
                    <td><?php echo e($game->crash_point); ?></td>
                    <td><?php echo e($game->crash_time); ?>s</td>
                    <td>R$ <?php echo e($game->user_bet_amount); ?></td>
                    <td>
                        <?php if($game->user_betting_point != 0): ?>
                        <?php echo e($game->user_betting_point); ?>

                        <?php else: ?>
                        <span style="color:red;">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($game->user_earning != 0): ?>
                        R$ <?php echo e($game->user_earning); ?>

                        <?php else: ?>
                        <span style="color:red;">-</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo timeago($game->updated_at); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>