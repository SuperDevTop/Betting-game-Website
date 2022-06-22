<!-- Header Content -->
<div class="content-header">
    <!-- Left Section -->
    <div>
        <!-- Toggle Sidebar -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
        <button type="button" class="btn btn-dual mr-1" data-toggle="layout" data-action="sidebar_toggle">
            <i class="fa fa-fw fa-bars"></i>
        </button>
        <!-- END Toggle Sidebar -->
    </div>
    <!-- END Left Section -->

    <!-- Right Section -->
    <div>
        <!-- User Dropdown -->
        <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-fw fa-user d-sm-none"></i>
                <span class="d-none d-sm-inline-block"><?php echo e(Auth::user()->name); ?></span>
                <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                    Admin
                </div>
                <div class="p-2">
                    <a class="dropdown-item" href="<?php echo e(url('admin/ProfileView')); ?>">
                        <i class="far fa-fw fa-user mr-1"></i> Perfil
                    </a>
                    <a class="dropdown-item" href="<?php echo e(url('admin/logout')); ?>">
                        <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END Right Section -->
</div>