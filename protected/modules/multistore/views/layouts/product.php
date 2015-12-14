<?php
/**
 * @var $this ProductBackendController
 * @var $content string
 */
$cssPath = Yii::getPathOfAlias($this->module->assetsPath) . '/css/multistore-backend.css';
Yii::app()->getClientScript()->registerCssFile(Yii::app()->getAssetManager()->publish($cssPath));

$this->menu = array_merge([
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.multistore', 'Manage products'), 'url' => ['/multistore/productBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.multistore', 'Create product'), 'url' => ['/multistore/productBackend/create']],
], $this->menu);
?>

<?php $this->beginContent($this->yupe->getBackendLayoutAlias('column2')); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>
