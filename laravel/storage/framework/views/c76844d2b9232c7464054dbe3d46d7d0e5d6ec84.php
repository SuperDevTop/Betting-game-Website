
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
<div class="container">
    <div class="list_card" style="overflow: auto;">
        <h3>Lista de saques pagos</h3>
        <table class="table table-vcenter">
            <thead>
                <tr>
                    <th style="width: 10%;">Encontro</th> <!--  -->
                    <th style="width: 5%;">ID</th> <!--  -->
                    <th style="width: 8%;">Nome</th> <!--  -->
                    <th style="width: 8%;">CPF</th> <!--  -->
                    <th style="width: 8%;">Banco</th> <!--  -->
                    <th style="width: 8%;">Agência</th> <!--  -->
                    <th style="width: 8%;">tipo de conta</th> <!--  -->
                    <th style="width: 8%;">Conta</th> <!--  -->
                    <th style="width: 7%;">Requeridos</th> <!--  -->
                    <th style="width: 7%;">Comissão</th> <!--  -->
                    <th style="width: 7%;">Paga</th> <!--  -->
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $withdraws; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(date("Y-m-d", strtotime($withdraw->created_at) - 3600 * 3)); ?></td>
                    <td>
                        <?php echo e($withdraw->id); ?> 
                    </td>
                    <td>
                        <?php echo e($withdraw->full_name); ?> 
                    </td>
                    <td>
                        <?php echo e($withdraw->cpf); ?> 
                    </td>
                    <td>
                        <?php echo e($withdraw->bank); ?> 
                    </td>
                    <td>
                        <?php echo e($withdraw->agency); ?> 
                    </td>
                    <td>
                        <?php if($withdraw->account_type == "checking_account"): ?>
                            Conta Corrente
                        <?php else: ?> 
                            Conta Poupança
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo e($withdraw->account); ?> 
                    </td>
                    <td>
                        R$ <?php echo e($withdraw->requested_amount); ?>

                    </td>
                    <td>
                        R$ <?php echo e($withdraw->requested_amount - $withdraw->paid_amount); ?>

                    </td>
                    <td>
                        R$ <?php echo e($withdraw->paid_amount); ?>

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