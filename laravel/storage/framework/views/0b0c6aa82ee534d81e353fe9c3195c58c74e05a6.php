
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
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Retirada pendente</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Lista de saques pendentes</li>
                    <li class="breadcrumb-item active" aria-current="page">Lista de retirada</li>
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
            <h3 class="block-title">lista de retirar</h3>
            <div class="block-options">
                <button class="btn btn-primary" id="delete"><i class="fa fa-trash-alt"></i> excluir</button>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons" id="pending-table">
                    <thead>
                        <tr>
                            <th style="width: 4%;">
                                <div class="custom-control custom-checkbox mb-1">
                                    <input type="checkbox" class="custom-control-input" id="delete_checkbox"/>
                                    <label class="custom-control-label" for="delete_checkbox"></label>
                                </div>
                            </th>
                            <th style="width: 10%;">Encontro</th> <!-- date -->
                            <th style="width: 8%;">ID</th> <!-- ID -->
                            <th style="width: 10%;">Nome</th> <!-- Nome -->
                            <th style="width: 10%;">CPF</th> <!-- CPF -->
                            <th style="width: 10%;">Banco</th> <!-- Bank -->
                            <th style="width: 10%;">Agência</th> <!-- Agency -->
                            <th style="width: 10%;">tipo de conta</th> <!-- Account_type -->
                            <th style="width: 10%;">Conta</th> <!-- Account -->
                            <th style="width: 10%;">Requeridos</th> <!-- Requested -->
                            <th style="width: 8%;">Açao</th> <!-- Action -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($withdraws as $withdraw) {
                        ?>
                        <tr data-id="<?php echo e($withdraw->id); ?>">
                            <td>
                                <div class="custom-control custom-checkbox mb-1">
                                    <input type="checkbox" class="custom-control-input" id="delete_checkbox-<?php echo e($withdraw->id); ?>"/>
                                    <label class="custom-control-label" for="delete_checkbox-<?php echo e($withdraw->id); ?>"></label>
                                </div>
                            </td>
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
                                <button class="btn btn-primary pay" data-target="#pay-modal" data-toggle="modal">Pay</button>
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
<div class="modal" id="pay-modal" tabindex="-1" role="dialog" aria-labelledby="pay-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Pagar</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?php echo e(url('admin/PayWithdrawPost')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                <div class="block-content">
                    <input type="text" name="id" hidden />
                    <lable>Por favor, insira o valor quanto você pagou</lable>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                R$
                            </span>
                        </div>
                        <input type="number" step="0.01" class="form-control" name="amount" required />
                    </div>
                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Salve</button>
                </div>
                </form>
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
    var table = $("#pending-table").dataTable({
                        language: {
                            searchPlaceholder: "procurar...",
                            info: "Exibindo _START_ a _END_ de _TOTAL_ registros",
                            paginate: {
                              previous: "anterior",
                              next: "next"
                            }
                        },
                        order:['1',"desc"],
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

    $(document).on("click", ".pay", function(){
        var id = $(this).parent().parent().attr("data-id");
        $("#pay-modal input[name=id]").val(id);
    });

    $(document).on("click", "#delete", function(){
        var arr_id = Array();
        $("#pending-table tbody tr").each(function(){
            if ($(this).find('td:nth-child(1) input').prop("checked") == true)
                arr_id.push($(this).attr('data-id'));
        });

        $.ajax({
            url:"/stage/admin/delete_withdraw_request",
            type:'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {ids:arr_id},
            success:function(req) {
                    
                window.location.reload();
                
                /*arr_id.forEach(function(id){
                    console.log(id);
                    var removingRow = $("#pending-table tbody tr[data-id="+id+"]").get(0);
                    table.fnDeleteRow(table.fnGetPosition(removingRow));
                });*/
            },
            error: function(ts) {
                console.log(ts);
            }
        });
    });

    $(document).on("change", '#delete_checkbox', function(){
        var status = $(this).prop("checked");
        $("#pending-table tbody tr").each(function(){
            $(this).find('td:nth-child(1) input').prop("checked", status);
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>