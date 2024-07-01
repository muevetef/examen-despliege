<?php

use Core\Session; ?>

<?php $succesmessage = Session::getFlashMessage('success_message'); ?>
<?php if ($succesmessage !== null) : ?>
    <div class="message bg-green-100 p-3 my-3">
        <?= $succesmessage ?>
    </div>
<?php endif ?>

<?php $errormessage = Session::getFlashMessage('error_message'); ?>
<?php if ($errormessage !== null) : ?>
    <div class="message bg-red-100 p-3 my-3">
        <?= $errormessage ?>
    </div>
<?php endif ?>