<?php
/**
 * Отображение для create:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    $this->breadcrumbs = array(
        Yii::app()->getModule('multistore')->getCategory() => array(),
        Yii::t('multistore', 'Организации') => array('/multistore/org/index'),
        Yii::t('multistore', 'Добавление'),
    );

    $this->pageTitle = Yii::t('multistore', 'Организации - добавление');

    $this->menu = array(
        array('icon' => 'fa fa-fw fa-list-alt',
			'label' => Yii::t('multistore', 'Управление организациями'),
			'url' => array('/multistore/orgBackend/index')),
        array('icon' => 'fa fa-fw fa-plus-square',
			'label' => Yii::t('multistore', 'Добавить организации'),
			'url' => array('/multistore/orgBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('multistore', 'Организации'); ?>
        <small><?php echo Yii::t('multistore', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>