<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <!-- Logo -->
            <a class="link-fx font-w600 font-size-lg text-white" href="<?php echo e(url('admin/')); ?>">
                <span class="smini-hidden">
                    <span class="text-white">Rocket</span><span class="text-white-75"></span> <span class="text-white font-size-base font-w400">Admin</span>
                </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                
                <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" data-toggle="layout" data-action="sidebar_style_toggle" href="javascript:void(0)">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </a>
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Side Navigation -->
    <div class="content-side content-side-full">
        <ul class="nav-main">
            <li class="nav-main-item">
                <a class="nav-main-link <?php echo e(Request::is('admin/home')?'active':''); ?>" href="<?php echo e(url('admin/home')); ?>">
                    <i class="nav-main-link-icon si si-speedometer"></i>
                    <span class="nav-main-link-name">Painel</span>
                    <!-- <span class="nav-main-link-badge badge badge-pill badge-success">5</span> -->
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link <?php echo e(Request::is('admin/UserListView')?'active':''); ?>" href="<?php echo e(url('admin/UserListView')); ?>">
                    <i class="nav-main-link-icon fa fa-users fa-2x" style="font-size: 16px;"></i>
                    <span class="nav-main-link-name">usuários</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link <?php echo e(Request::is('admin/SpamListView')?'active':''); ?>" href="<?php echo e(url('admin/SpamListView')); ?>">
                    <i class="nav-main-link-icon fa fa-exclamation-triangle fa-2x" style="font-size: 16px;"></i>
                    <span class="nav-main-link-name">Spam</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link <?php echo e(Request::is('admin/GameListView')?'active':''); ?>" href="<?php echo e(url('admin/GameListView')); ?>">
                    <i class="nav-main-link-icon fa fa-gamepad fa-2x" style="font-size: 16px;"></i>
                    <span class="nav-main-link-name">Rocket</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link <?php echo e(Request::is('admin/DepositHistory')?'active':''); ?>" href="<?php echo e(url('admin/DepositHistory')); ?>">
                    <i class="nav-main-link-icon fa fa-plus-square fa-2x" style="font-size: 16px;"></i>
                    <span class="nav-main-link-name">Depositos</span>
                </a>
            </li>
            <li class="nav-main-item <?php echo e(Request::is('admin/PendingWithdrawHistory')||Request::is('admin/PaidWithdrawHistory')?'open':''); ?>">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon far fa-minus-square fa-2x" style="font-size: 16px;"></i>
                    <span class="nav-main-link-name">Saques</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link <?php echo e(Request::is('admin/PendingWithdrawHistory')?'active':''); ?>" href="<?php echo e(url('admin/PendingWithdrawHistory')); ?>">
                            <span class="nav-main-link-name">Pendente</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link <?php echo e(Request::is('admin/PaidWithdrawHistory')?'active':''); ?>" href="<?php echo e(url('admin/PaidWithdrawHistory')); ?>">
                            <span class="nav-main-link-name">Paga</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--
            <li class="nav-main-item">
                <a class="nav-main-link" href="<?php echo e(url('admin/CommissionSettingView')); ?>">
                    <i class="nav-main-link-icon far fa-money-bill-alt fa-2x" style="font-size: 16px;"></i>
                    <span class="nav-main-link-name">comissão</span>
                </a>
            </li>
            -->
            <li class="nav-main-item">
                <a class="nav-main-link" href="<?php echo e(url('admin/logout')); ?>">
                    <i class="nav-main-link-icon fa fa-sign-out-alt fa-2x" style="font-size: 16px;"></i>
                    <span class="nav-main-link-name">Sair</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- END Side Navigation -->
</nav>