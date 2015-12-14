<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.type', 'Product types') => ['/multistore/typeBackend/index'],
    Yii::t('MultistoreModule.multistore', 'Creating'),
];

$this->pageTitle = Yii::t('MultistoreModule.type', 'Product types - create');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.type', 'Type manage'), 'url' => ['/multistore/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.type', 'Create type'), 'url' => ['/multistore/typeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.type', 'Product type'); ?>
        <small><?php echo Yii::t('MultistoreModule.multistore', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'availableAttributes' => $availableAttributes]); ?>
