<?php if( session_has('errors') ): ?>
<div class="alert alert-warning">
    <p class="m-0">
        <span class="">Revisar los siguientes datos:</span> 
        <span class="text-danger"><?=implode(", ",session_get('errors'))?></span>
    </p>
</div>
<?php session_erase('errors') ?>
<?php endif ?>
