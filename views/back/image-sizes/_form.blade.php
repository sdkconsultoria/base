<div class="p-4 bg-white mb-5 shadow rounded-lg">
    <?= $model->input('name') ?>
    <div class="flex flex-row">
        <div class="w-1/5">
            <?= $model->input('height') ?>
        </div>
        <div class="w-1/5 pl-3">
            <?= $model->input('width') ?>
        </div>
        <div class="w-1/5 pl-3">
            <?= $model->input('quality') ?>
        </div>
        <div class="w-1/5 pl-3">
            <?= $model->input('aspect') ?>
        </div>
        <div class="w-1/5 pl-3">
            <?= $model->input('fill') ?>
        </div>
    </div>
</div>
