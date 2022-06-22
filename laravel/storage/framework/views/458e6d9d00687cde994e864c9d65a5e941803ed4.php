
<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
        <h3>R$ <?php echo e(number_format($total_deposit_amount, 2)); ?></h3>
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
                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(date("Y-m-d", strtotime($transaction->created_at) - 3600 * 3)); ?></td>
                    <td>
                        Você deposita dinheiro de <span style="color:#ffb119;"><?php echo e($transaction->from); ?></span> conta de pagamento.
                    </td>
                    <td>
                        R$ <?php echo e($transaction->amount); ?>

                    </td>
                    <td>
                        <?php echo e($transaction->transaction_id); ?>

                    </td>
                    <td>
                        <?php if($transaction->status == "pending"): ?>
                        <span style="color:#ffb119;"><?php echo e($transaction->status); ?></span>
                        <?php else: ?>
                            <?php echo e($transaction->status); ?>

                        <?php endif; ?>
                    </td>
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