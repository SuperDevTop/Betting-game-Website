
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('admin-assets/theme/js/plugins/datatables/dataTables.bootstrap4.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('admin-assets/theme/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css')); ?>">
<style type="text/css">
    .row>div{
        padding-bottom: 5px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">usuários</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Gerenciar usuários</li>
                    <li class="breadcrumb-item active" aria-current="page">usuários Lista</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->
<div class="content">
    <!-- Full Table -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Usuários</h3>
            <div class="block-options">
                
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons" id="user-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 10%;">Nome completo</th>
                            <th style="width: 10%;">E-mail</th>
                            <th style="width: 10%;">CPF</th>
                            <th style="width: 10%;">Saldo</th>
                            <th style="width: 10%;">anunciante</th>
                            <th style="width: 13%;">bônus de referência</th>
                            <th style="width: 10%;">Usuários de referência</th>
                            <th style="width: 10%;">Ganhos de afiliados</th>
                            <th class="text-center" style="width: 17%;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($users as $user) {
                                $user_obj = DB::table("users")->where("id", $user->affiliate_id)->first();
                        ?>
                        <tr data-id="<?php echo e($user->id); ?>" status="<?php echo e($user->status); ?>">
                            <td>
                                <?php echo e($user->id); ?>

                            </td>
                            <td>
                                <?php echo e($user->full_name); ?>

                            </td>
                            <td>
                                <?php echo e($user->email); ?>

                            </td>
                            <td>
                                <span><?php echo e($user->cpf); ?></span>
                                <a href="#" class="cpf" style="float: right;" data-target="#set-cpf-modal" data-toggle="modal"><i class="fa fa-edit"></i></a>
                            </td>
                            <td>
                                R$ <span><?php echo e(number_format($user->balance, 2)); ?></span>
                                <a href="#" class="balance" style="float: right;" data-target="#set-balance-modal" data-toggle="modal"><i class="fa fa-edit"></i></a>
                            </td>
                            <td><?php echo e($user_obj?$user_obj->full_name:""); ?></td>
                            <td>
                                <span><?php echo e($user->referral_rate); ?></span>%
                                <a href="#" class="referral_rate" style="float: right;" data-target="#set-referral-bonus-modal" data-toggle="modal"><i class="fa fa-edit"></i></a>
                            </td>
                            <td><?php echo e($user->referral_users); ?></td>
                            <td>R$ <?php echo e(number_format($user->referral_earning)); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a class="btn btn-danger" href="<?php echo e(url('admin/BlockUser/'.$user->id)); ?>">
                                        Bloquear
                                    </a>
                                    <a class="btn btn-primary" href="<?php echo e(url('admin/UserCrashGames/'.$user->id)); ?>">
                                        <i class="si si-game-controller"></i>
                                    </a>
                                    <a class="btn btn-success" href="<?php echo e(url('admin/LoginUser/'.$user->id)); ?>" target="_blank">
                                        <i class="si si-login"></i>
                                    </a><!-- 
                                    <a class="btn btn-primary" href="<?php echo e(url('admin/ReferralUserListView/'.$user->id)); ?>" title="Usuários de referência">
                                        <i class="fab fa-affiliatetheme"></i>
                                    </a> -->
                                </div>
                            </td>
                        </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<div class="modal" id="set-referral-bonus-modal" tabindex="-1" role="dialog" aria-labelledby="set-referral-bonus-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Definir bônus de referência</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="input-group">
                        <input type="text" name="id" hidden />
                        <input type="number" step="0.01" class="form-control" name="referral_bonus"/>
                        <span class="input-group-text input-group-text-alt" style="border-radius: 0px !important;">
                            %
                        </span>
                    </div>
                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="referral_rate_submit" data-dismiss="modal">Salve</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="set-balance-modal" tabindex="-1" role="dialog" aria-labelledby="set-referral-bonus-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Editar saldo do usuário</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <input type="text" name="id" hidden />
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                R$
                            </span>
                        </div>
                        <input type="number" step="0.01" class="form-control" name="balance"/>
                    </div>
                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="bonus_submit" data-dismiss="modal">Salve</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="set-cpf-modal" tabindex="-1" role="dialog" aria-labelledby="set-referral-bonus-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Editar CPF do usuário</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <input type="text" name="id" hidden />
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                CPF
                            </span>
                        </div>
                        <input type="text" class="form-control" name="cpf"/>
                    </div>
                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="bonus_submit" data-dismiss="modal">Salve</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script src="<?php echo e(asset('admin-assets/theme/js/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/theme/js/plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/theme/js/plugins/datatables/buttons/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.flash.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.colVis.min.js')); ?>"></script>

<script type="text/javascript">
    $("#user-table").dataTable({
                        language: {
                            searchPlaceholder: "procurar...",
                            info: "Exibindo _START_ a _END_ de _TOTAL_ registros",
                            paginate: {
                              previous: "anterior",
                              next: "next"
                            }
                        },
                        pageLength: 20,
                        lengthMenu: [
                            [5, 10, 20, 50, 100],
                            [5, 10, 20, 50, 100]
                        ],
                        autoWidth: !1,
                        buttons: [{
                            extend: "copy",
                            className: "btn btn-sm btn-primary"
                        }, {
                            extend: "csv",
                            className: "btn btn-sm btn-primary"
                        }, {
                            extend: "print",
                            className: "btn btn-sm btn-primary"
                        }],
                        dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                    });

    $(document).on("click", ".referral_rate", function(){
        var referral_rate = $(this).parent().find("span").text();
        var id = $(this).parent().parent().attr("data-id");

        $("#set-referral-bonus-modal input[name=referral_bonus]").val(referral_rate);
        $("#set-referral-bonus-modal input[name=id]").val(id);
    });
    
    $("#referral_rate_submit").click(function(){
        var id = $("#set-referral-bonus-modal input[name=id]").val();
        var referral_rate = $("#set-referral-bonus-modal input[name=referral_bonus]").val();
        $.ajax({
            url:"/stage/admin/SetReferralRate",
            type:'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {id:id, referral_rate:referral_rate},
            success:function(req) {
                $("tr[data-id="+ id +"]").find("td:nth-child(6) span").text(referral_rate);
            },
            error: function(ts) {
                console.log(ts);
            }
        });
    });

    $(document).on("click", ".balance", function(){
        var balance = $(this).parent().find("span").text();
        var id = $(this).parent().parent().attr("data-id");

        console.log(balance);

        $("#set-balance-modal input[name=balance]").val(balance);
        $("#set-balance-modal input[name=id]").val(id);
    });
    
    $(document).on("click", ".cpf", function(){
        var cpf = $(this).parent().find("span").text();
        var id = $(this).parent().parent().attr("data-id");

        console.log(cpf);

        $("#set-cpf-modal input[name=cpf]").val(cpf);
        $("#set-cpf-modal input[name=id]").val(id);
    });
    
    $("#bonus_submit").click(function(){
        var id = $("#set-balance-modal input[name=id]").val();
        var balance = $("#set-balance-modal input[name=balance]").val();
        $.ajax({
            url:"/stage/admin/EditUserBalance",
            type:'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {id:id, balance:balance},
            success:function(req) {
                $("tr[data-id="+ id +"]").find("td:nth-child(4) span").text(balance);
            },
            error: function(ts) {
                console.log(ts);
            }
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>