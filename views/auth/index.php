<?php $template->fill('content') ?>

<div class="row mt-4">
    <div class="col-sm col-sm-4 offset-sm-4">
        <div class="card shadow">
            <div class="card-body">
                <form action="<?= url('signing') ?>" method='post'>
                    <p class="lead text-muted font-weight-bold">APPNAME</p>
                    <div class="form-group">
                        <input type="email" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <p class="text-right m-0">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </p>
                </form>
            </div>
            <div class="card-footer text-center">
                <?php if( session_has('flash') && session_get('flash') === 'not_auth' ): ?>
                    <span class="text-danger">Wrong username or password</span>
                <?php session_erase('flash'); endif ?>
            </div>
        </div>
    </div>
</div>

<?php $template->stop() ?>
<?php $template->expand('layouts/login') ?>
