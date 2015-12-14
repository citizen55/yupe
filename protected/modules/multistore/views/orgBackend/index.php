<?php
/**
 * Отображение для index:
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
        Yii::t('multistore', 'Управление'),
    );

    $this->pageTitle = Yii::t('multistore', 'Организации - управление');

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
        <small><?php echo Yii::t('multistore', 'управление'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('multistore', 'Поиск организаций');?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('org-grid', {
            data: $(this).serialize()
        });

        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p> <?php echo Yii::t('multistore', 'В данном разделе представлены средства управления организациями'); ?>
</p>

<?php
 $this->widget('yupe\widgets\CustomGridView', array(
'id'           => 'org-grid',
'type'         => 'striped condensed',
'dataProvider' => $model->search(),
'filter'       => $model,
'columns'      => array(
        'id',
        'slug',
        'name',
        'image',
        'user_id',
        'type_id',
        /*
        'phone_1',
        'phone_2',
        'fax',
        'location',
        */
array(
'class' => 'yupe\widgets\CustomButtonColumn',
),
),
)); ?>
