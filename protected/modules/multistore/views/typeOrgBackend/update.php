<?php
/**
 * Отображение для update:
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
        $model->name => array('/multistore/TypeOrg/view', 'id' => $model->id),
        Yii::t('multistore', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('multistore', 'Типы организаций - редактирование');

    $this->menu = array(
        array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('multistore', 'Управление Типами организаций'), 'url' => array('/multistore/TypeOrg/index')),
        array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('multistore', 'Добавить Типа организации'), 'url' => array('/multistore/TypeOrg/create')),
        array('label' => Yii::t('multistore', 'Тип организации') . ' «' . mb_substr($model->id, 0, 32) . '»'),
        array('icon' => 'fa fa-fw fa-pencil', 'label' => Yii::t('multistore', 'Редактирование Типа организации'), 'url' => array(
            '/multistore/TypeOrg/update',
            'id' => $model->id
        )),
        array('icon' => 'fa fa-fw fa-eye', 'label' => Yii::t('multistore', 'Просмотреть Типа организации'), 'url' => array(
            '/multistore/TypeOrg/view',
            'id' => $model->id
        )),
        array('icon' => 'fa fa-fw fa-trash-o', 'label' => Yii::t('multistore', 'Удалить Типа организации'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/multistore/TypeOrg/delete', 'id' => $model->id),
            'confirm' => Yii::t('multistore', 'Вы уверены, что хотите удалить Типа организации?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('multistore', 'Редактирование') . ' ' . Yii::t('multistore', 'Типа организации'); ?>        <br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>