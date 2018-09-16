<?php $template->fill('content') ?>
<h1>Example</h1>
<form action="<?= address('example/store') ?>" method="post" autocomplete="off">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email">
            </div>
        </div>
    </div>
    <button class="btn btn-success" type="submit">Save example</button>
</form>
<br>
<table class="table table-sm">
    <tbody>
        <?php foreach($examples as $example): ?>
        <?php $formId = 'exampleUpdate'.$example->id ?>
        <tr>
            <td>
                <input type="text" class="form-control form-control-sm" form="<?= $formId ?>" name="name" value="<?= $example->name ?>">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" form="<?= $formId ?>" name="email" value="<?= $example->email ?>">
            </td>
            <td class="text-nowrap text-right">
                <form action="<?= address('example/update/'.$example->id) ?>" method='POST' id="<?= $formId ?>">
                    <button class="btn btn-warning btn-sm" type="submit">Update</button>
                    <a href="<?= address('example/delete/'.$example->id) ?>" class="btn btn-danger btn-sm">Eliminar</a>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php $template->stop() ?>
<?php $template->expand('layouts/main') ?>