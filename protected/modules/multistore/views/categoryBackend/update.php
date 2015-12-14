<?php
$this->breadcrumbs = [
    Yii::t('MultistoreModule.category', 'Categories') => ['/multistore/categoryBackend/index'],
    $model->name => ['/multistore/categoryBackend/view', 'id' => $model->id],
    Yii::t('MultistoreModule.multistore', 'Edition'),
];

$this->pageTitle = Yii::t('MultistoreModule.category', 'Categories - edition');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.category', 'Manage categories'), 'url' => ['/multistore/categoryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('MultistoreModule.category', 'Create category'), 'url' => ['/multistore/categoryBackend/create']],
    ['label' => Yii::t('MultistoreModule.category', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('MultistoreModule.category', 'Update category'),
        'url' => [
            '/multistore/categoryBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('MultistoreModule.category', 'View category'),
        'url' => [
            '/multistore/categoryBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('MultistoreModule.category', 'Delete category'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/multistore/categoryBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('MultistoreModule.category', 'Do you really want to remove category?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.category', 'Updating category'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
