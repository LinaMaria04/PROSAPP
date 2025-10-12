<?php $__env->startSection('content'); ?>
        <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Dashboard</h3>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Personal</h5>
                                    <p class="card-text">Gestiona el personal de la empresa.</p>
                                    <a href="<?php echo e(route('personal.index')); ?>" class="btn btn-primary">Ver Personal</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Roles</h5>
                                    <p class="card-text">Administra los roles y permisos.</p>
                                    <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-primary">Ver Roles</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Mi Perfil</h5>
                                    <p class="card-text">Gestiona tu información personal y contraseña.</p>
                                    <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-primary">Ver Perfil</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Usuarios</h5>
                                    <p class="card-text">Gestiona los usuarios de la empresa.</p>
                                    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-primary">Ver Usuarios</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\prosarapp\bakend\resources\views/dashboard.blade.php ENDPATH**/ ?>