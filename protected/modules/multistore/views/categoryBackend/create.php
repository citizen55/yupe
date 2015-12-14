<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.category', 'Categories') => ['/multistore/categoryBackend/index'],
    Yii::t('MultistoreModule.multistore', 'Creating'),
];

$this->pageTitle = Yii::t('MultistoreModule.category', 'Categories - create');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.category', 'Manage categories'), 'url' => ['/multistore/categoryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.category', 'Create category'), 'url' => ['/multistore/categoryBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.category', 'Category'); ?>
        <small><?php echo Yii::t('MultistoreModule.multistore', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
