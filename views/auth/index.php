<?php $template->fill('content') ?>

<div class="row mt-4">
    <div class="col-sm col-sm-4 offset-sm-4">
        <div class="card shadow">
            <div class="card-body">
                <form action="<?= url('signing') ?>" method='post'>
                    <p class="lead text-muted font-weight-bold">LA POTOSINA EXPRESS</p>
                    <div class="form-group">
                        <input type="email" class="form-control" name="usuario" placeholder="Usuario" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                    </div>
                    <p class="text-right m-0">
                        <button type="submit" class="btn btn-primary">Iniciar sesion</button>
                    </p>
        
                    
                </form>
            </div>
            <div class="card-footer text-center">
                <?php if( session_has('wrong_sign') ): ?>
                    <span class="text-danger">Usuario o contraseña incorrectos</span>
                <?php session_erase('wrong_sign'); endif ?>
            </div>
        </div>
    </div>
</div>

<?php $template->stop() ?>
<?php $template->expand('layouts/login') ?>
