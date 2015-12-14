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
        Yii::t('multistore', 'Организации') => array('/multistore/org/index'),
        $model->name => array('/multistore/org/view', 'id' => $model->id),
        Yii::t('multistore', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('multistore', 'Организации - редактирование');

    $this->menu = array(
        array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('multistore', 'Управление организациями'), 'url' => array('/multistore/org/index')),
        array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('multistore', 'Добавить организации'), 'url' => array('/multistore/org/create')),
        array('label' => Yii::t('multistore', 'Организация') . ' «' . mb_substr($model->id, 0, 32) . '»'),
        array('icon' => 'fa fa-fw fa-pencil', 'label' => Yii::t('multistore', 'Редактирование организации'), 'url' => array(
            '/multistore/org/update',
            'id' => $model->id
        )),
        array('icon' => 'fa fa-fw fa-eye', 'label' => Yii::t('multistore', 'Просмотреть организации'), 'url' => array(
            '/multistore/org/view',
            'id' => $model->id
        )),
        array('icon' => 'fa fa-fw fa-trash-o', 'label' => Yii::t('multistore', 'Удалить организации'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/multistore/org/delete', 'id' => $model->id),
            'confirm' => Yii::t('multistore', 'Вы уверены, что хотите удалить организации?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('multistore', 'Редактирование') . ' ' . Yii::t('multistore', 'организации'); ?>        <br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>