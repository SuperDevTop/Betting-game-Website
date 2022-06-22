
<?php $__env->startSection('css'); ?>
<style type="text/css">
    .block-card{
        margin-top: 30px;
        background-color: rgb(30,30,30);
        padding: 50px 20px 50px 20px;
        color: white;
        border-radius: 5px;
    }
    .block-card h2{
        color: white;
        font-weight: bold;
        border-bottom: 1px solid white;
        margin-bottom: 50px;
    }
    .block-card p{
        font-size: 20px;
        color: red;
    }

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container game-container">
    <div class="block-card">
        <h2>Bloqueado</h2>
        <p>Você não pode fazer nada antes de resolver o problema.<br/>
            Sua conta foi bloqueada. Envie um email para <a href="mailto:onataslenz@gmail.com">jonataslenz@gmail.com</a> para saber qual é o problema.</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>