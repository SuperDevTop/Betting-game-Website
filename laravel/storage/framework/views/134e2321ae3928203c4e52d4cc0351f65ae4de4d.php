<?php $__env->startSection('css'); ?>


<style type="text/css">

    .deposit_card{

        background-color: rgb(30,30,30);

        border-radius: 5px;

        padding: 20px 20px 20px 20px;

        margin: 30px;

    }

    .deposit_card h2,p,label{

        color: white;

    }

    .bold{

        font-weight: bold;

    }

    .deposit_card input{

        background-color: black !important;

        color: white !important;

    }

</style>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>



<div class="container game-container">

    <div class="deposit_card">

        <h2 class="bold">Depósito</h2>

        <p>Por favor, insira o valor do depósito.</p>

        <form method="post" action="<?php echo e(url('deposit_post')); ?>" id="deposit_form">

            <?php echo csrf_field(); ?>

            <div class="form-group">

                <label for="example-text-input">Nome Completo</label>

                <input type="text" class="form-control" name="name" required="">

            </div>

            <div class="form-group">

                <label for="example-text-input">CPF</label>

                <input type="text" class="form-control" name="cpf" required="">

            </div>

            <div class="form-group">

                <label for="example-text-input">Valor</label>

                <input type="number" step="1" value="20" class="form-control" id="amount" name="amount"/>

            </div>

            <div style="padding:30px 0px 20px 0px; text-align:right;">

                <button class="btn btn-primary" id="deposit" type="button">Depósito</button>

            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>

<script src="<?php echo e(asset('admin-assets/theme/js/plugins/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>

<script type="text/javascript">
    $("#deposit").click(function(){
        var amount = $("#amount").val();
        if (amount < 20)
        {
            Dashmix.helpers('notify', {type: 'warning', icon: 'fa fa-exclamation mr-1', 
                message: 'O valor do depósito deve ser superior a R$ 20.'});
        }
        else
            $("#deposit_form").submit();
    });
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>