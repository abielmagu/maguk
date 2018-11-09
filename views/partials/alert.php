<?php if( session_has('flash') ): $flash = session_get('flash') ?>
<?php if( isset($flash['message']) ): ?>

<div class="alert <?= $flash['message']['color'] ?>">
    <b><?= $flash['message']['text'] ?></b>
</div>
<?php session_erase('flash') ?>

<?php endif ?>
<?php endif ?>
