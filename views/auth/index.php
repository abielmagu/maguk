<?php $template->fill('content') ?>

<div class="row mt-4">
    <div class="col-sm col-sm-4 offset-sm-4 shadow rounded bg-white">
        <form action="#" class="py-3" method='post'>
            <p class="lead text-muted font-weight-bold">APPNAME</p>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <p class="text-right m-0">
                <button type="submit" class="btn btn-primary">Sign</button>
            </p>
        </form>
    </div>
</div>

<?php $template->stop() ?>
<?php $template->expand('layouts/login') ?>
