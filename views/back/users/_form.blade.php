<div class="p-4 bg-white mb-5 shadow rounded-lg">
    <?= $model->input('name') ?>
    <?= $model->input('lastname') ?>
    <?= $model->input('lastname_2') ?>
    <?= $model->input('email') ?>
    <?= $model->input('password')->passwordInput() ?>
    <?= $model->input('password_confirmation')->passwordInput() ?>
</div>
