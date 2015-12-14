<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 */

$this->layout = 'product';

$this->breadcrumbs = [
    Yii::t('MultistoreModule.multistore', 'Products') => ['/multistore/productBackend/index'],
    Yii::t('MultistoreModule.multistore', 'Creating'),
];

$this->pageTitle = Yii::t('MultistoreModule.multistore', 'Products - creating');
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.multistore', 'Products'); ?>
        <small><?php echo Yii::t('MultistoreModule.multistore', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
