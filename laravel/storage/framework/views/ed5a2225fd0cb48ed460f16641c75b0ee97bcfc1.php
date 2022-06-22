
<?php $__env->startSection('css'); ?>
<style type="text/css">
    .success_card{
        background-color: rgb(30,30,30);
        border-radius: 5px;
        padding: 50px 20px 50px 30px;
        margin: 30px;
        text-align: center;
    }
    .success_card h1,p{
        color: white;
    }
    .bold{
        font-weight: bold;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="success_card">
        <i class="si si-close fa-2x" style="color:#82b54b; font-size: 100px;"></i>
        <h1 class="bold">erro</h1>
        <p>VAlgum erro desconhecido está surgindo. Por favor, tente novamente..</p>
        <a href="<?php echo e(url('deposit')); ?>" class="btn btn-primary">Deposite mais</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>