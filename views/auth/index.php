<?php $template->fill('content') ?>

<div class="row mt-4">
    <div class="col-sm col-sm-4 offset-sm-4 shadow rounded bg-white">
        <form action="<?= url('signing') ?>" class="py-3" method='post'>
            <p class="lead text-muted font-weight-bold">LA POTOSINA EXPRESS</p>
            <div class="form-group">
                <input type="text" class="form-control" name="usuario" placeholder="Usuario">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña">
            </div>
            <p class="text-right m-0">
                <button type="submit" class="btn btn-primary">Iniciar sesion</button>
            </p>
        </form>
    </div>
</div>

<?php $template->stop() ?>
<?php $template->expand('layouts/login') ?>
