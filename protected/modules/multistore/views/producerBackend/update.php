<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.producer', 'Producers') => ['/multistore/producerBackend/index'],
    $model->name_short => ['/multistore/producerBackend/view', 'id' => $model->id],
    Yii::t('MultistoreModule.multistore', 'Edition'),
];

$this->pageTitle = Yii::t('MultistoreModule.producer', 'Producers - edition');

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
        <?php echo Yii::t('MultistoreModule.producer', 'Updating producer'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
