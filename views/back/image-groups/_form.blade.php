<div class="p-4 bg-white mb-5 shadow rounded-lg">
    <div class="flex flex-row">
        <div class="w-4/5">
            <?= $model->input('identifier') ?>
        </div>
        <div class="w-1/5 pl-3">
            <?= $model->translate->input('language')->dropDown(Base::languages()) ?>
        </div>
    </div>
    <?= $model->translate->input('name') ?>
    <?= $model->translate->input('images')->imagesInput([], true) ?>
</div>
