<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.category', 'Categories') => ['/multistore/categoryBackend/index'],
    Yii::t('MultistoreModule.multistore', 'Manage'),
];

$this->pageTitle = Yii::t('MultistoreModule.category', 'Categories - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.category', 'Manage categories'), 'url' => ['/multistore/categoryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.category', 'Create category'), 'url' => ['/multistore/categoryBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.category', 'Categories'); ?>
        <small><?php echo Yii::t('MultistoreModule.multistore', 'administration'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'category-grid',
        'sortableRows'      => true,
        'sortableAjaxSave'  => true,
        'sortableAttribute' => 'sort',
        'sortableAction'    => '/multistore/categoryBackend/sortable',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/multistore/categoryBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns' => [
            [
                'name'   => 'image',
                'type'   => 'raw',
                'value'  => '$data->image ? CHtml::image($data->getImageUrl(50, 50), $data->name, array("width"  => 50, "height" => 50, "class" => "img-thumbnail")) : ""',
                'filter' => false
            ],
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/multistore/categoryBackend/update", "id" => $data->id))',
            ],
            [
                'name' => 'slug',
                'type' => 'raw',
                'value' => 'CHtml::link($data->slug, array("/multistore/categoryBackend/update", "id" => $data->id))',
            ],
            [
                'name' => 'parent_id',
                'value' => '$data->getParentName()',
                'filter' => CHtml::activeDropDownList($model, 'parent_id', MultistoreCategory::model()->getFormattedList(), ['encode' => false, 'empty' => '', 'class' => 'form-control'])
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/multistore/categoryBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    MultistoreCategory::STATUS_PUBLISHED => ['class' => 'label-success'],
                    MultistoreCategory::STATUS_DRAFT => ['class' => 'label-default'],
                ],
            ],
            [
                'header' => Yii::t('MultistoreModule.multistore', 'Products'),
                'value' => function($data) {
                        return CHtml::link($data->productCount, ['/multistore/productBackend/index', "Product[category_id]" => $data->id], ['class' => 'badge']);
                    },
                'type' => 'raw'
            ],
            [
                'class'  => 'yupe\widgets\CustomButtonColumn',
                'buttons' => [
                    'front_view' => [
                        'visible' => function ($row, $data) {
                                return $data->status == MultistoreCategory::STATUS_PUBLISHED;
                            }
                    ]
                ]
            ],
        ],
    ]
); ?>
