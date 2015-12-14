<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.type', 'Product types') => ['/multistore/typeBackend/index'],
    $model->name => ['/multistore/typeBackend/view', 'id' => $model->id],
    Yii::t('MultistoreModule.multistore', 'Edition'),
];

$this->pageTitle = Yii::t('MultistoreModule.type', 'Product types - edition');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.type', 'Type manage'), 'url' => ['/multistore/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.type', 'Create type'), 'url' => ['/multistore/typeBackend/create']],
    ['label' => Yii::t('MultistoreModule.type', 'Product type') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('MultistoreModule.type', 'Update type'),
        'url' => [
            '/multistore/typeBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('MultistoreModule.type', 'View type'),
        'url' => [
            '/multistore/typeBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('MultistoreModule.type', 'Delete type'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/multistore/typeBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('MultistoreModule.multistore', 'Do you really want to remove this type?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.type', 'Updating type'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'availableAttributes' => $availableAttributes]); ?>
