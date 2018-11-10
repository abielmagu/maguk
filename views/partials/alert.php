<?php if( session_has('flash', 'message') ): $message = session_get('flash', 'message') ?>

<?php if($message['status'] === 'info'): ?>
<div class="alert alert-info">
    <span class="alert-heading">Mensaje:</span>
    <span><?= $message['text'] ?></span>
</div>

<?php elseif($message['status'] === 'success'): ?>
<div class="alert alert-success">
    <span class="alert-heading">Mensaje:</span>
    <span><?= $message['text'] ?></span>
</div>

<?php elseif($message['status'] === 'warning'): ?>
<div class="alert alert-warning">
    <span class="alert-heading">Mensaje:</span>
    <span><?= $message['text'] ?></span>
</div>

<?php elseif($message['status'] === 'danger'): ?>
<div class="alert alert-danger">
    <span class="alert-heading">Mensaje:</span>
    <span><?= $message['text'] ?></span>
</div>

<?php elseif($message['status'] === 'dark'): ?>
<div class="alert alert-dark">
    <span class="alert-heading">Mensaje:</span>
    <span><?= $message['text'] ?></span>
</div>

<?php elseif($message['status'] === 'secondary'): ?>
<div class="alert alert-secondary">
    <span class="alert-heading">Mensaje:</span>
    <span><?= $message['text'] ?></span>
</div>

<?php elseif($message['status'] === 'light'): ?>
<div class="alert alert-light">
    <span class="alert-heading">Mensaje:</span>
    <span><?= $message['text'] ?></span>
</div>

<?php else: ?>
<div class="alert alert-primary">
    <span class="alert-heading">Mensaje:</span>
    <span><?= $message['text'] ?></span>
</div>

<?php endif ?>

<?php endif ?>
