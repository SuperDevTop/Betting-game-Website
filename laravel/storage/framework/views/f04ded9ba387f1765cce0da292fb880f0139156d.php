
<?php $__env->startSection('css'); ?>
<style type="text/css">
    .referral_user_list_card{
        background-color: rgb(30,30,30);
        border-radius: 5px;
        padding: 20px 15px 20px 15px;
        margin-top: 30px;
        overflow: auto;
    }
    .referral_user_list_card table th{
        background-color: rgb(40,40,40);
        font-size: 15px;
        color: white;
    }
    .referral_user_list_card table td{
        color: white;
        font-size: 14px;
    }
    .referral_user_list_card h3,span{
        color: white;
    }
    .bold{
        font-weight: bold;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="referral_user_list_card">
        <h3 class="bold">
            Usuários de referência
            <span style="float:right;"><?php echo e($referral_users->count()); ?> Usuários</span>
        </h3>
        <table class="table table-vcenter">
            <thead>
                <tr>
                    <th style="width: 20%;">Nome</th> <!-- Name -->
                    <th style="width: 20%;">E-mail</th> <!-- Email -->
                    <th style="width: 15%;">Equilíbrio</th> <!-- Balance -->
                    <th style="width: 15%;">Status</th> <!-- Status -->
                    <th style="width: 25%;">Registrado em</th> <!-- Registered at -->
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $referral_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php echo e($user->full_name); ?>

                    </td>
                    <td>
                        <?php echo e($user->email); ?>

                    </td>
                    <td>
                        R$ <?php echo e($user->balance); ?>

                    </td>
                    <td>
                        <?php if($user->status == "active"): ?>
                            <span><?php echo e($user->status); ?></span>
                        <?php else: ?>
                            <span style="color:red;"><?php echo e($user->status); ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e(date("Y-m-d", strtotime($user->created_at) - 3600 * 3)); ?></td>
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