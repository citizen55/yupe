<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 */

$this->layout = 'product';

$this->breadcrumbs = [
    Yii::t('MultistoreModule.multistore', 'Products') => ['/multistore/productBackend/index'],
    $model->name => ['/multistore/productBackend/view', 'id' => $model->id],
    Yii::t('MultistoreModule.multistore', 'Edition'),
];

$this->pageTitle = Yii::t('MultistoreModule.multistore', 'Products - edition');

$this->menu = [
    ['label' => Yii::t('MultistoreModule.multistore', 'Product') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('MultistoreModule.multistore', 'Update product'),
        'url' => [
            '/multistore/productBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('MultistoreModule.multistore', 'View product'),
        'url' => [
            '/multistore/productBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('MultistoreModule.multistore', 'Delete product'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/multistore/productBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('MultistoreModule.multistore', 'Do you really want to remove product?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MultistoreModule.multistore', 'Updating product'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'searchModel' => $searchModel]); ?>
