<?php $__env->startSection('css'); ?>

<style type="text/css">

    .deposit_card{

        background-color: rgb(30,30,30);

        border-radius: 5px;

        padding: 20px 20px 20px 20px;

        margin: 30px;    }

    .deposit_card h1,h2,p,label,b{

        color: white !important;

    }

    .deposit_card p{

        margin-bottom: 0px;

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

        <h1>Deposito PIX</h1>

        <!-- <form class="frmCLR"> -->

            <img class="logoPix" src="<?php echo e(asset('front-assets/img/pix.png')); ?>" width="120px">

            <b class="depValor"><?php echo "R$ ".($dados['total_cents']/100).",00";?></b>

            <br/><br/>

            <img class="depQrcode" src="<?php echo $dados['pix']['qrcode'];?>" width="220px"><br/><br/>

            <p>Leia o código QR abaixo no aplicativo Pix</p>

            <p>Conclua o depósito com seu banco</p>

            <p>Seu saldo de $R e qualquer bônus de depósito aplicável serão creditados</p>

            <p style="font-size:0.5rem; word-break: break-all;"><?php echo $dados['pix']['qrcode_text'];?>&nbsp;

                <button style="display: block; margin: 10px auto; background-image: linear-gradient(0deg,#283D71,#466DA5); border: 0;" type="button" onclick="copyToClipboard('<?php echo $dados['pix']['qrcode_text'];?>')" class="btn btn-sm btn-secondary" title="clique para copiar">

                    PIX Copia e Cola

                </button>

            </p>
            <span style="display: block;width: 260px;margin: 0 auto;text-align: center;color: #fff;margin-top: 20px;padding: 9px;background-color: #1e1e1e;border: 1px solid #ccc;border-radius: 3px;">Aguardando Pagamento <i class="fa fa-spinner" style="margin: 0 0 0 15px;transform: rotate(0deg);animation: moveSpinner 1s infinite;"></i></span>
            <style>
                @keyframes  moveSpinner {
              from {transform: rotate(0deg);}
              to {transform: rotate(359deg);}
            }
            </style>

        <!-- </form> -->

    </div>

</div>

<input id="order_id" value="<?php echo e($dados['id']); ?>" hidden/>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>

<script src="<?php echo e(asset('admin-assets/theme/js/plugins/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>

<script type="text/javascript">

    function copyToClipboard(text) {

       const elem = document.createElement('textarea');

       elem.value = text;

       document.body.appendChild(elem);

       elem.select();

       document.execCommand('copy');

       document.body.removeChild(elem);

    }

    function analise(){

        $.ajax({

            url:"/stage/deposit_status_post",

            type:'post',

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },

            data: {order_id:$("#order_id").val()},

            success:function(req) {

                console.log(req);

                let status = req;

                if(status == 'paid'){

                    location.href = "/stage/deposit_success_view";

                }else{

                    setTimeout('analise()',3000);

                }

            },

            error: function(ts) {

                console.log(ts);

            }

        });

    }

    analise();

</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>