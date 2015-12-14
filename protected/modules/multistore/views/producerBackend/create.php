<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.producer', 'Producers') => ['/multistore/producerBackend/index'],
    Yii::t('MultistoreModule.multistore', 'Creating'),
];

$this->pageTitle = Yii::t('MultistoreModule.producer', 'Producers - create');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.producer', 'Manage producers'), 'url' => ['/multistore/producerBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.producer', 'Create producer'), 'url' => ['/multistore/producerBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.producer', 'Producer'); ?>
        <small><?php echo Yii::t('MultistoreModule.multistore', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
