<?php
/* @var $model Producer */
$this->breadcrumbs = [
    Yii::t('MultistoreModule.producer', 'Producers') => ['/multistore/producerBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('MultistoreModule.producer', 'Producers - view');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.producer', 'Manage producers'), 'url' => ['/multistore/producerBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.producer', 'Create producer'), 'url' => ['/multistore/producerBackend/create']],
    ['label' => Yii::t('MultistoreModule.producer', 'Producer') . ' «' . mb_substr($model->name_short, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('MultistoreModule.producer', 'Update producer'),
        'url' => [
            '/multistore/producerBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('MultistoreModule.producer', 'View producer'),
        'url' => [
            '/multistore/producerBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('MultistoreModule.producer', 'Delete producer'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/multistore/producerBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('MultistoreModule.producer', 'Do you really want to remove this producer?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.producer', 'Viewing producer'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            'id',
            'name_short',
            'name',
            'slug',
            [
                'name' => 'status',
                'value' => $model->getStatusTitle(),
            ],
            'order',
            [
                'name' => 'image',
                'type' => 'raw',
                'value' => function($model){
                        return $model->image ? CHtml::image($model->getImageUrl()) : '';
                    },
            ],
            [
                'name' => 'short_description',
                'type' => 'html'
            ],
            [
                'name' => 'description',
                'type' => 'html'
            ],
            'meta_title',
            'meta_keywords',
            'meta_description'
        ],
    ]
); ?>
