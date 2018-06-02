<?php $template->fill('content') ?>
<h1>Dasboard index</h1>
<form action="<?= address('dashboard/store') ?>" method="post" autocomplete="off">
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="text" class="form-control" name="email">
    </div>
    <button class="btn btn-success" type="submit">Save</button>
</form>
<br>
<h1>Guests</h1>
<table class="table">
    <tbody>
        <?php foreach($guests as $guest): ?>
        <?php $formId = 'guestUpdate'.$guest->id ?>
        <tr>
            <td>
                <input type="text" class="form-control" form="<?= $formId ?>" name="name" value="<?= $guest->name ?>">
            </td>
            <td>
                <input type="text" class="form-control" form="<?= $formId ?>" name="email" value="<?= $guest->email ?>">
            </td>
            <td class="text-nowrap text-right">
                <form action="<?= address('dashboard/update/'.$guest->id) ?>" method='POST' id="<?= $formId ?>">
                    <button class="btn btn-warning btn-sm" type="submit">Update</button>
                    <a href="<?= address('dashboard/delete/'.$guest->id) ?>" class="btn btn-danger btn-sm">Eliminar</a>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php $template->stop() ?>
<?php $template->extends('layouts/main') ?>