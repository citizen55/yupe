<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.attr', 'Attributes') => ['/multistore/attributeBackend/index'],
    $model->name => ['/multistore/attributeBackend/view', 'id' => $model->id],
    Yii::t('MultistoreModule.multistore', 'Edition'),
];

$this->pageTitle = Yii::t('MultistoreModule.attr', 'Attributes - editing');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.attr', 'Manage attributes'), 'url' => ['/multistore/attributeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.attr', 'Create attribute'), 'url' => ['/multistore/attributeBackend/create']],
    ['label' => Yii::t('MultistoreModule.attr', 'Attribute') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('MultistoreModule.attr', 'Update attribute'),
        'url' => [
            '/multistore/attributeBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('MultistoreModule.attr', 'View attribute'),
        'url' => [
            '/multistore/attributeBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('MultistoreModule.attr', 'Delete attribute'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/multistore/attributeBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('MultistoreModule.attr', 'Do you really want to remove attribute?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.attr', 'Updating attribute'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
