<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <!-- Logo -->
            <a class="link-fx font-w600 font-size-lg text-white" href="<?php echo e(url('/')); ?>">
                <span class="smini-hidden">
                    <img src="<?php echo e(asset('front-assets/img/ico_game.png')); ?>" style="height: 30px; width: 30px;"/> Million Rocket
                </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                
                
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
                <a class="nav-main-link <?php echo e(Request::is('crash_game_play')?'active':''); ?>" href="<?php echo e(url('crash_game_play')); ?>">
                    <i class="nav-main-link-icon fa fa-chart-line"></i>
                    <span class="nav-main-link-name">Jogo</span>
                    <!-- <span class="nav-main-link-badge badge badge-pill badge-success">5</span> -->
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link <?php echo e(Request::is('crash_game_history')?'active':''); ?>" href="<?php echo e(url('crash_game_history')); ?>">
                    <i class="nav-main-link-icon fa fa-gamepad"></i>
                    <span class="nav-main-link-name">Histórico do jogo</span>
                    <!-- <span class="nav-main-link-badge badge badge-pill badge-success">5</span> -->
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link <?php echo e(Request::is('transaction_history')?'active':''); ?>" href="<?php echo e(url('transaction_history')); ?>">
                    <i class="nav-main-link-icon fa fa-exchange-alt"></i>
                    <span class="nav-main-link-name">Histórico de depósitos</span>
                    <!-- <span class="nav-main-link-badge badge badge-pill badge-success">5</span> -->
                </a>
            </li>
            <li class="nav-main-item <?php echo e(Request::is('affiliate_link')||Request::is('affiliate_user_list_view')||Request::is('affiliate_earning')?'open':''); ?>">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fab fa-affiliatetheme"></i>
                    <span class="nav-main-link-name">Afiliados</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link <?php echo e(Request::is('affiliate_link')?'active':''); ?>" href="<?php echo e(url('affiliate_link')); ?>">
                            <span class="nav-main-link-name">link</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link <?php echo e(Request::is('affiliate_user_list_view')?'active':''); ?>" href="<?php echo e(url('affiliate_user_list_view')); ?>">
                            <span class="nav-main-link-name">usuário</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link <?php echo e(Request::is('affiliate_earning')?'active':''); ?>" href="<?php echo e(url('affiliate_earning')); ?>">
                            <span class="nav-main-link-name">ganhos</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item <?php echo e(Request::is('withdraw')||Request::is('withdraw_pending_history')||Request::is('withdraw_success_history')?'open':''); ?>">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon far fa-fw fa-minus-square mr-1"></i>
                    <span class="nav-main-link-name">Retirar</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link <?php echo e(Request::is('withdraw')?'active':''); ?>" href="<?php echo e(url('withdraw')); ?>">
                            <span class="nav-main-link-name">Retirar</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link <?php echo e(Request::is('withdraw_pending_history')?'active':''); ?>" href="<?php echo e(url('withdraw_pending_history')); ?>">
                            <span class="nav-main-link-name">Histórico pendente</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link <?php echo e(Request::is('withdraw_success_history')?'active':''); ?>" href="<?php echo e(url('withdraw_success_history')); ?>">
                            <span class="nav-main-link-name">Histórico pago</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item <?php echo e(Request::is('login_ip_history')?'open':''); ?>">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fa fa-user-secret mr-1"></i>
                    <span class="nav-main-link-name">segurança</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link <?php echo e(Request::is('login_ip_history')?'active':''); ?>" href="<?php echo e(url('login_ip_history')); ?>">
                            <span class="nav-main-link-name">Histórico de IP de login</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- END Side Navigation -->
</nav>