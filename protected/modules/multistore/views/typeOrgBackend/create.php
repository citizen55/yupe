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
        Yii::t('multistore', 'Типы организаций') => array('/multistore/TypeOrg/index'),
        Yii::t('multistore', 'Добавление'),
    );

    $this->pageTitle = Yii::t('multistore', 'Типы организаций - добавление');

    $this->menu = array(
        array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('multistore', 'Управление Типами организаций'), 'url' => array('/multistore/TypeOrg/index')),
        array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('multistore', 'Добавить Типа организации'), 'url' => array('/multistore/TypeOrg/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('multistore', 'Типы организаций'); ?>
        <small><?php echo Yii::t('multistore', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>