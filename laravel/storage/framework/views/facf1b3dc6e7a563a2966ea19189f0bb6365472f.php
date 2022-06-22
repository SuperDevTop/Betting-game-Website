<?php $__env->startSection('css'); ?>

<style type="text/css">

    .withdraw_card{

        background-color: rgb(30,30,30);

        border-radius: 5px;

        padding: 20px 20px 20px 20px;

        margin: 30px;

    }

    .withdraw_card h2,p,label{

        color: white;

    }

    .bold{

        font-weight: bold;

    }

    .withdraw_card input{

        background-color: black !important;

        color: white !important;

    }

    .withdraw_card select{

        background-color: black !important;

        color: white !important;

    }

    .invalid-error{

        color:red;

        display:flex;

        margin-top:5px;

    }

</style>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>



<div class="container">

    <div class="withdraw_card">

        <h2 class="bold">Retirar</h2>

        <p class="aviso">Por favor, insira este campo e envie o pedido de retirada</p>
        
        <span class="progressBox" style="display: block; border: 1px solid #999; margin: -10px 0 20px 0; background-color: #303030;">
            <span class="progressBar" style="display: block; width: 20%; height: 18px; text-align: center; font-size: 0.8rem; color: #fff; background-color: #4368a0;">
                <span class="progressText" style="position: absolute;">-</span>
            </span>
        </span>

        <form method="post" action="<?php echo e(url('withdraw_request_post')); ?>">

            <?php echo csrf_field(); ?>

            <div class="form-group">

                <label for="example-text-input">Nome Completo</label>

                <?php

                    $full_name = Auth::user()->full_name;

                    if (old('name')) $full_name = old('name');

                ?>

                <input type="text" class="form-control" name="name" value="<?php echo e($full_name); ?>">

                <?php if($errors->has("name")): ?>

                    <span class="invalid-error">

                        <?php echo e($errors->first('name')); ?>


                    </span>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label for="example-text-input">CPF</label>

                <input type="text" class="form-control" name="cpf" value="<?php echo e(old('cpf')); ?>">

                <?php if($errors->has("cpf")): ?>

                    <span class="invalid-error">

                        <?php echo e($errors->first('cpf')); ?>


                    </span>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label for="example-text-input">Banco</label>

                <input type="text" class="form-control" name="bank" value="<?php echo e(old('bank')); ?>">

                <?php if($errors->has("bank")): ?>

                    <span class="invalid-error">

                        <?php echo e($errors->first('bank')); ?>


                    </span>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label for="example-text-input">Agencia</label>

                <input type="text" class="form-control" name="agency" value="<?php echo e(old('agency')); ?>">

                <?php if($errors->has("agency")): ?>

                    <span class="invalid-error">

                        <?php echo e($errors->first('agency')); ?>


                    </span>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label for="example-text-input">Tipo Conta</label>

                <select class="form-control" name="account_type" required="">

                    <option <?php if(old('account_type')=="checking_account"): ?> selected <?php endif; ?> value="checking_account">Conta Corrente</option>

                    <option <?php if(old('account_type')=="saving_account"): ?> selected <?php endif; ?> value="saving_account">Conta Poupança</option>

                </select>

                <?php if($errors->has("account_type")): ?>

                    <span class="invalid-error">

                        <?php echo e($errors->first('account_type')); ?>


                    </span>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label for="example-text-input">Conta</label>

                <input type="text" class="form-control" name="account" value="<?php echo e(old('account')); ?>">

                <?php if($errors->has("account")): ?>

                    <span class="invalid-error">

                        <?php echo e($errors->first('account')); ?>


                    </span>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label for="example-text-input">Valor</label>

                <input type="number" step="0.01" min="50" class="form-control" name="amount" value="<?php echo e(old('amount')); ?>"/>

                <?php if($errors->has("amount")): ?>

                    <span class="invalid-error">

                        <?php echo e($errors->first('amount')); ?>


                    </span>

                <?php endif; ?>

            </div>

            <div class="btEnviar" style="padding:30px 0px 20px 0px; text-align:right;">

                <button class="btn btn-primary" type="submit">Enviar pedido</button>

            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>

<script src="<?php echo e(asset('admin-assets/theme/js/plugins/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>

<script type="text/javascript">

</script>

<script>  
$.post("/transacoes/total_jogadas.php", function(data){
   var depApo = data.split("/");
   var dif = parseFloat(depApo[1]) - parseFloat(depApo[0]);
   var per = 100 - ((dif/parseFloat(depApo[1]))*100);
   
   $("span.progressText").html("R$"+parseFloat(depApo[0]).toFixed(2)+" de R$"+parseFloat(depApo[1]).toFixed(2));
   $("span.progressBar").css({'width':per+'%'});
   
   if(dif > 0){
       $('p.aviso').html("É preciso apostar pelo menos 1x o valor depositados para solicitar o saque!");
       $('div.btEnviar').html("");
       $('span.progressBox').css({'display':'none'});
   }
   
   console.log(per);
});
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>