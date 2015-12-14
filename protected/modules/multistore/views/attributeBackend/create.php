<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.attr', 'Attributes') => ['/multistore/attributeBackend/index'],
    Yii::t('MultistoreModule.multistore', 'Creating'),
];

$this->pageTitle = Yii::t('MultistoreModule.attr', 'Attributes - creating');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.attr', 'Manage attributes'), 'url' => ['/multistore/attributeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.attr', 'Create attribute'), 'url' => ['/multistore/attributeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.attr', 'Attribute'); ?>
        <small><?php echo Yii::t('MultistoreModule.multistore', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
