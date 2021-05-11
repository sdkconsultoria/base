<div class="p-4 bg-white mb-5 shadow rounded-lg">
    <?= $model->input('blog_id')->dropDown($model->select('blog')) ?>

    <div class="flex flex-row">
        <div class="w-4/5">
            <?= $model->input('identifier') ?>
        </div>
        <div class="w-1/5 pl-3">
            <?= $model->translate->input('language')->dropDown(Base::languages()) ?>
        </div>
    </div>

    <?= $model->translate->input('title') ?>
    <?= $model->translate->input('subtitle') ?>
    <?= $model->translate->input('description')->textarea(['class' => 'jodit w-full']) ?>
    <?= $model->translate->input('images')->imagesInput() ?>
    <?= $model->input('tags')->taggableInput() ?>
</div>
