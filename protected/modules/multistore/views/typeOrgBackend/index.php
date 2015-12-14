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
        Yii::t('multistore', 'Типы организаций') => array('/multistore/TypeOrg/index'),
        Yii::t('multistore', 'Управление'),
    );

    $this->pageTitle = Yii::t('multistore', 'Типы организаций - управление');

    $this->menu = array(
        array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('multistore', 'Управление Типами организаций'), 'url' => array('/multistore/TypeOrg/index')),
        array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('multistore', 'Добавить Типа организации'), 'url' => array('/multistore/TypeOrg/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('multistore', 'Типы организаций'); ?>
        <small><?php echo Yii::t('multistore', 'управление'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('multistore', 'Поиск Типов организаций');?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('type-org-grid', {
            data: $(this).serialize()
        });

        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p> <?php echo Yii::t('multistore', 'В данном разделе представлены средства управления Типами организаций'); ?>
</p>

<?php
 $this->widget('yupe\widgets\CustomGridView', array(
'id'           => 'type-org-grid',
'type'         => 'striped condensed',
'dataProvider' => $model->search(),
'filter'       => $model,
'columns'      => array(
        'id',
        'parent_id',
        'slug',
        'name',
        'image',
        'meta_title',
        /*
        'meta_description',
        'meta_keywords',
        'status',
        'sort',
        */
array(
'class' => 'yupe\widgets\CustomButtonColumn',
),
),
)); ?>
