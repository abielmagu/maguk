<?php $template->fill('content') ?>
<h1>Dasboard index</h1>
<form action="<?= url('dashboard/create') ?>" method="post" autocomplete="off">
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="form-group">
        <label for="">Lastname</label>
        <input type="text" class="form-control" name="lastname">
    </div>
    <button class="btn btn-success" type="submit">Save</button>
</form>
<?php $template->stop() ?>
<?php $template->extends('layouts/main') ?>