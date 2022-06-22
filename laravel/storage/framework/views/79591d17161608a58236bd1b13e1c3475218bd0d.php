<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-image" style="background-image: url('../admin-assets/theme/media/various/bg_dashboard.jpg');">
    <div class="bg-white-90">
        <div class="content content-full">
            <div class="row">
                <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="py-4 py-md-0 text-center text-md-left invisible" data-toggle="appear">
                        <h1 class="font-size-h2 mb-2">Dashboard</h1>
                        <h2 class="font-size-lg font-w400 text-muted mb-0">Hoje é uma ótima!</h2>
                    </div>
                </div>
                <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="row w-100 text-center">
                        <div class="col-6 col-xl-4 offset-xl-4 invisible" data-toggle="appear" data-timeout="300">
                            <p class="font-size-h3 font-w600 text-body-color-dark mb-0">
                                R$ <?php echo e(number_format($total_betting_amount, 2)); ?>

                            </p>
                            <p class="font-size-sm font-w700 text-uppercase mb-0">
                                <i class="far fa-chart-bar text-muted mr-1"></i> Valor total da aposta
                            </p>
                        </div>
                        <div class="col-6 col-xl-4 invisible" data-toggle="appear" data-timeout="600">
                            <p class="font-size-h3 font-w600 text-body-color-dark mb-0">
                                R$ <?php echo e(number_format($total_betting_amount - $total_win_amount, 2)); ?>

                            </p>
                            <p class="font-size-sm font-w700 text-uppercase mb-0">
                                <i class="far fa-chart-bar text-muted mr-1"></i> Ganhos totais
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-md-6 col-xl-3 invisible" data-toggle="appear">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between" style="height: 128px;">
                    <div style="padding-left: 10px;">
                        <i class="fa fa-user-friends fa-2x"></i>
                    </div>
                    <div class="ml-3 text-right">
                        <p class="text-muted mb-0">
                            usuários
                        </p>
                        <p class="font-size-h3 font-w300 mb-0">
                            <?php echo e($user_cnt); ?>

                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3 invisible" data-toggle="appear" data-timeout="200">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between" style="height: 128px;">
                    <div style="padding-left: 10px;">
                        <i class="fa fa-gamepad fa-2x" style="color:blue;"></i>
                    </div>
                    <div class="ml-3 text-right">
                        <p class="text-muted mb-0">
                            Jogos criados
                        </p>
                        <p class="font-size-h3 font-w300 mb-0">
                            <?php echo e($game_cnt); ?>

                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3 invisible" data-toggle="appear" data-timeout="400">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between" style="height: 128px;">
                    <div style="padding-left: 10px;">
                        <i class="fa fa-plus-square fa-2x" style="color:red;"></i>
                    </div>
                    <div class="ml-3 text-right">
                        <p class="text-muted mb-0">
                            Depósito total
                        </p>
                        <p class="font-size-h3 font-w300 mb-0">
                            R$ <?php echo e(number_format($total_deposit_amount, 2)); ?>

                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3 invisible" data-toggle="appear" data-timeout="600">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between" style="height: 128px;">
                    <div style="padding-left: 10px;">
                        <i class="fab fa-affiliatetheme fa-2x" style="color:green;"></i>
                    </div>
                    <div class="ml-3 text-right">
                        <p class="text-muted mb-0">
                            Valor total do afiliado
                        </p>
                        <p class="font-size-h3 font-w300 mb-0">
                            R$ <?php echo e(number_format($affiliate_amount, 2)); ?>

                        </p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!--
    <div class="block block-rounded block-mode-loading-refresh invisible" data-toggle="appear">
        <div class="block-header block-header-default">
            <h3 class="block-title">Ganhos</h3>
            <div class="block-options">
                <div class="btn-group btn-group-sm btn-group-toggle mr-2" data-toggle="buttons" role="group" aria-label="Earnings Select Date Group">
                    <label class="btn btn-light" data-toggle="dashboard-chart-set-week">
                        <input type="radio" name="dashboard-chart-options" id="dashboard-chart-options-week"> Week
                    </label>
                    <label class="btn btn-light" data-toggle="dashboard-chart-set-month">
                        <input type="radio" name="dashboard-chart-options" id="dashboard-chart-options-month"> Month
                    </label>
                    <label class="btn btn-light active" data-toggle="dashboard-chart-set-year">
                        <input type="radio" name="dashboard-chart-options" id="dashboard-chart-options-year" checked> Year
                    </label>
                </div>
                <button type="button" class="btn-block-option align-middle" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div>
        <div class="block-content block-content-full overflow-hidden">
            <div class="pull-x pull-b">
                <canvas class="js-chartjs-dashboard-earnings" style="height: 340px;"></canvas>
            </div>
        </div>
    </div>

    <div class="row row-deck">
        <div class="col-xl-6 invisible" data-toggle="appear">
            <div class="block block-rounded block-mode-loading-refresh">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Usuário principal</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                        <button type="button" class="btn-block-option">
                            <i class="si si-cloud-download"></i>
                        </button>
                        <div class="dropdown">
                            <button type="button" class="btn-block-option" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="si si-wrench"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="far fa-fw fa-user mr-1"></i> New Users
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="far fa-fw fa-bookmark mr-1"></i> VIP Users
                                </a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-pencil-alt"></i> Manage
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-dark">
                    <form action="be_pages_dashboard.html" method="POST" onsubmit="return false;">
                        <input type="text" class="form-control form-control-alt" placeholder="Search Users..">
                    </form>
                </div>
                <div class="block-content">
                    <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm">
                        <thead>
                            <tr class="text-uppercase">
                                <th class="font-w700 text-center" style="width: 120px;">Avatar</th>
                                <th class="font-w700">Nome</th>
                                <th class="d-none d-sm-table-cell font-w700">Acesso</th>
                                <th class="font-w700 text-center" style="width: 60px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <img class="img-avatar img-avatar32 img-avatar-thumb" src="<?php echo e(asset('admin-assets/theme/media/avatars/avatar3.jpg')); ?>" alt="">
                                </td>
                                <td>
                                    <div class="font-w600 font-size-base">Laura Carr</div>
                                    <div class="text-muted">carol@example.com</div>
                                </td>
                                <td class="d-none d-sm-table-cell font-size-base">
                                    <span class="badge badge-dark">VIP</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="Edit User">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img class="img-avatar img-avatar32 img-avatar-thumb" src="<?php echo e(asset('admin-assets/theme/media/avatars/avatar10.jpg')); ?>" alt="">
                                </td>
                                <td>
                                    <div class="font-w600 font-size-base">Henry Harrison</div>
                                    <div class="text-muted">smith@example.com</div>
                                </td>
                                <td class="d-none d-sm-table-cell font-size-base">
                                    <span class="badge badge-secondary">Pro</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="Edit User">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img class="img-avatar img-avatar32 img-avatar-thumb" src="<?php echo e(asset('admin-assets/theme/media/avatars/avatar11.jpg')); ?>" alt="">
                                </td>
                                <td>
                                    <div class="font-w600 font-size-base">Jack Estrada</div>
                                    <div class="text-muted">john@example.com</div>
                                </td>
                                <td class="d-none d-sm-table-cell font-size-base">
                                    <span class="badge badge-dark">VIP</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="Edit User">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img class="img-avatar img-avatar32 img-avatar-thumb" src="<?php echo e(asset('admin-assets/theme/media/avatars/avatar3.jpg')); ?>" alt="">
                                </td>
                                <td>
                                    <div class="font-w600 font-size-base">Marie Duncan</div>
                                    <div class="text-muted">lori@example.com</div>
                                </td>
                                <td class="d-none d-sm-table-cell font-size-base">
                                    <span class="badge badge-secondary">Pro</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="Edit User">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img class="img-avatar img-avatar32 img-avatar-thumb" src="<?php echo e(asset('admin-assets/theme/media/avatars/avatar3.jpg')); ?>" alt="">
                                </td>
                                <td>
                                    <div class="font-w600 font-size-base">Jose Parker</div>
                                    <div class="text-muted">jack@example.com</div>
                                </td>
                                <td class="d-none d-sm-table-cell font-size-base">
                                    <span class="badge badge-success">Free</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="Edit User">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6 invisible" data-toggle="appear" data-timeout="200">
            <div class="block block-rounded block-mode-loading-refresh">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Melhor aposta</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                        <button type="button" class="btn-block-option">
                            <i class="si si-cloud-download"></i>
                        </button>
                        <div class="dropdown">
                            <button type="button" class="btn-block-option" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="si si-wrench"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-sync fa-spin text-warning mr-1"></i> Pending
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="far fa-fw fa-times-circle text-danger mr-1"></i> Cancelled
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="far fa-fw fa-check-circle text-success mr-1"></i> Cancelled
                                </a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-eye mr-1"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-dark">
                    <form action="be_pages_dashboard.html" method="POST" onsubmit="return false;">
                        <input type="text" class="form-control form-control-alt" placeholder="Search Purchases..">
                    </form>
                </div>
                <div class="block-content">
                    <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm">
                        <thead>
                            <tr class="text-uppercase">
                                <th class="d-none d-sm-table-cell font-w700">Encontro</th>
                                <th class="font-w700">Status</th>
                                <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 120px;">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="font-w600">2022-10-20 10:23 AM</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">Vencer</span>
                                <td class="d-none d-sm-table-cell text-right">
                                    <span class="font-w600 text-success">$999,99</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-w600">2022-10-20 10:23 AM</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">Vencer</span>
                                <td class="d-none d-sm-table-cell text-right">
                                    <span class="font-w600 text-success">$1000,00</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-w600">2022-10-20 10:23 AM</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">Perder</span>
                                <td class="d-none d-sm-table-cell text-right">
                                    <span class="font-w600 text-danger">$999,99</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-w600">2022-10-20 10:23 AM</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">Vencer</span>
                                <td class="d-none d-sm-table-cell text-right">
                                    <span class="font-w600 text-success">$999,99</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-w600">2022-10-20 10:23 AM</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">Vencer</span>
                                <td class="d-none d-sm-table-cell text-right">
                                    <span class="font-w600 text-success">$129,00</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-w600">2022-10-20 10:23 AM</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">Perder</span>
                                <td class="d-none d-sm-table-cell text-right">
                                    <span class="font-w600 text-danger">$93,93</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-w600">2022-10-20 10:23 AM</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">Perder</span>
                                <td class="d-none d-sm-table-cell text-right">
                                    <span class="font-w600 text-danger">$2359,99</span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    -->
</div>
<!-- END Page Content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('admin-assets/theme/js/plugins/jquery-sparkline/jquery.sparkline.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/theme/js/plugins/chart.js/Chart.bundle.min.js')); ?>"></script>

<!-- Page JS Code -->
<script src="<?php echo e(asset('admin-assets/theme/js/pages/be_pages_dashboard.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>