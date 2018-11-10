<?php if( session_has('flash', 'message') ): $message = session_get('flash', 'message') ?>

<?php if($message['status'] === 'info'): ?>
<span class="text-info"><?= $message['text'] ?></span>

<?php elseif($message['status'] === 'success'): ?>
<span class="text-success"><?= $message['text'] ?></span>

<?php elseif($message['status'] === 'warning'): ?>
<span class="text-warning"><?= $message['text'] ?></span>

<?php elseif($message['status'] === 'danger'): ?>
<span class="text-danger"><?= $message['text'] ?></span>

<?php elseif($message['status'] === 'dark'): ?>
<span class="text-dark"><?= $message['text'] ?></span>

<?php elseif($message['status'] === 'secondary'): ?>
<span class="text-secondary"><?= $message['text'] ?></span>

<?php elseif($message['status'] === 'light'): ?>
<span class="text-light"><?= $message['text'] ?></span>

<?php else: ?>
<span class="text-primary"><?= $message['text'] ?></span>

<?php endif; session_erase('flash') ?>

<?php endif ?>
