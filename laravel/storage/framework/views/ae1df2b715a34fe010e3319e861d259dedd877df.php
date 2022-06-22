
<?php $__env->startSection('css'); ?>
<style type="text/css">
    .block-content>div{
        padding-top: 10px;
    }
    .block-content{
        padding-bottom: 30px;
    }
    .error-note{
        color:red;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Editar perfil</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Perfil</li>
                    <li class="breadcrumb-item active" aria-current="page">Editar</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content">
    <!-- Elements -->
    <form action="<?php echo e(url('admin/EditProfilePost')); ?>" method="post">
        <?php echo csrf_field(); ?>
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Editar perfil</h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-4">
                    nome
                </div>
                <div class="col-md-8">
                    <?php
                        $name = Auth::user()->name;
                        if ($errors->any())
                            $name = old('name');
                    ?>

                    <input type="text" class="form-control" id="name" name="name" placeholder="nome." value="<?php echo e($name); ?>">
                    <?php if($errors->has('name')): ?>
                        <span class="error-note">
                            <strong><?php echo e($errors->first('name')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    número de telefone
                </div>
                <div class="col-md-8">
                    <?php
                        $phone = Auth::user()->phone;
                        if ($errors->any())
                            $phone = old('phone');
                    ?>

                    <input type="text" class="form-control" id="phone" name="phone" placeholder="número de telefone." value="<?php echo e($phone); ?>">
                    <?php if($errors->has('phone')): ?>
                        <span class="error-note">
                            <strong><?php echo e($errors->first('phone')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    E-mail
                </div>
                <div class="col-md-8">
                    <?php
                        $email = Auth::user()->email;
                        if ($errors->any())
                            $email = old('email');
                    ?>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo e($email); ?>" placeholder="E-mail.">
                    <?php if($errors->has('email')): ?>
                        <span class="error-note">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    senha
                </div>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="password" name="password" value="******" placeholder="senha.">
                    <?php if($errors->has('password')): ?>
                        <span class="error-note">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    ConfirmaÇão Da Senha
                </div>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" value="******" placeholder="ConfirmaÇão Da Senha.">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="<?php echo e(url('admin/ViewProfile')); ?>" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
            
        </div>
    </div>
    </form>
    <!-- END Elements -->
</div>
<!-- END Page Content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>