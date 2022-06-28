<?php

use app\models\RegisterModel;
use app\core\form\Form;

/** @var RegisterModel $model */
?>

<h1>Register</h1>

<?php $form = Form::begin() ?>
<?= $form->input('text', $model, 'name') ?>
<?= $form->input('email', $model, 'email') ?>
<div class="row mb-4">
    <div class="col-md-6">
        <?= $form->input('password', $model, 'pass') ?>
    </div>
    <div class="col-md-6">
        <?= $form->input('password', $model, 'passConfirm') ?>
    </div>
</div>
<?= $form->submitButton() ?>
<?= Form::end() ?>
