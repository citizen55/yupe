<?php

/**
 * @var $model ProductLinkType
 */

$this->breadcrumbs = [
    Yii::t('MultistoreModule.multistore', 'Link types') => ['/multistore/linkBackend/typeIndex'],
    Yii::t('MultistoreModule.multistore', 'Manage'),
];

$this->pageTitle = Yii::t('MultistoreModule.multistore', 'Link types - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('MultistoreModule.multistore', 'Manage link types'), 'url' => ['/multistore/linkBackend/typeIndex']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('MultistoreModule.multistore', 'Link types') ?>
        <small><?= Yii::t('MultistoreModule.multistore', 'manage') ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#add-toggle">
        <i class="glyphicon glyphicon-plus">&nbsp;</i>
        <?= Yii::t('MultistoreModule.multistore', 'Add') ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="add-toggle" class="collapse out add-form">
    <?php
    /* @var $form TbActiveForm */
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
            'id' => 'question-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'action' => ['/multistore/linkBackend/typeCreate'],
            'type' => 'vertical',
            'htmlOptions' => ['class' => 'well'],
        ]
    ); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model, 'code'); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model, 'title'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <?php $this->widget(
                'bootstrap.widgets.TbButton',
                [
                    'buttonType' => 'submit',
                    'context' => 'primary',
                    'label' => Yii::t('MultistoreModule.multistore', 'Create'),
                ]
            ); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'question-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'actionsButtons' => false,
        'hideBulkActions' => true,
        'columns' => [
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'code',
                'editable' => [
                    'url' => $this->createUrl('/multistore/linkBackend/typeInline'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($model, 'code', ['class' => 'form-control']),
            ],
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'title',
                'editable' => [
                    'url' => $this->createUrl('/multistore/linkBackend/typeInline'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($model, 'title', ['class' => 'form-control']),
            ],
            [
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => [
                        'url' => function ($data) {
                            return Yii::app()->createUrl('/multistore/linkBackend/typeDelete', ['id' => $data->id]);
                        }
                    ]
                ]
            ],
        ],
    ]
); ?>
