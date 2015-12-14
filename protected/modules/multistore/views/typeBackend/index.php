<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.type', 'Product types') => ['/multistore/typeBackend/index'],
    Yii::t('MultistoreModule.multistore', 'Manage'),
];

$this->pageTitle = Yii::t('MultistoreModule.type', 'Product types - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.type', 'Type manage'), 'url' => ['/multistore/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.type', 'Create type'), 'url' => ['/multistore/typeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.type', 'Product types'); ?>
        <small><?php echo Yii::t('MultistoreModule.multistore', 'administration'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'type-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => [
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/multistore/typeBackend/update", "id" => $data->id))',
            ],
            [
                'name'  => 'main_category_id',
                'value' => function($data) {
                        return $data->category ? $data->category->name : '---';
                    },
                'filter' => false
            ],
            [
                'header' => Yii::t('MultistoreModule.multistore', 'Products'),
                'value' => function($data) {
                        return CHtml::link($data->productCount, ['/multistore/productBackend/index', "Product[type_id]" => $data->id], ['class' => 'badge']);
                    },
                'type' => 'raw'
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
