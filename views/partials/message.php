<?php if( session_has('flash', 'message') ): $message = session_get('flash', 'message') ?>

<?php if($messsage['status'] === 'info'): ?>
<span class="text-info"><?= $message['text'] ?></span>

<?php elseif($messsage['status'] === 'success'): ?>
<span class="text-success"><?= $message['text'] ?></span>

<?php elseif($messsage['status'] === 'warning'): ?>
<span class="text-warning"><?= $message['text'] ?></span>

<?php elseif($messsage['status'] === 'danger'): ?>
<span class="text-danger"><?= $message['text'] ?></span>

<?php elseif($messsage['status'] === 'dark'): ?>
<span class="text-dark"><?= $message['text'] ?></span>

<?php elseif($messsage['status'] === 'secondary'): ?>
<span class="text-secondary"><?= $message['text'] ?></span>

<?php elseif($messsage['status'] === 'light'): ?>
<span class="text-light"><?= $message['text'] ?></span>

<?php else: ?>
<span class="text-primary"><?= $message['text'] ?></span>

<?php endif ?>

<?php endif ?>
