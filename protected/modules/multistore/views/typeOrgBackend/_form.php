<?php
/**
 * Отображение для _form:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 *
 *   @var $model TypeOrg
 *   @var $form TbActiveForm
 *   @var $this TypeOrgController
 **/
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id' => 'product-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => ['enctype' => 'multipart/form-data', 'class' => 'well'],
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('multistore', 'Поля, отмеченные'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('multistore', 'обязательны.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup(
					$model, 'parent_id', array(
						'widgetOptions' => array(
							'data' => CHtml::listData(TypeOrg::model()->findAll(), 'id', 'name'),
							'htmlOptions' => array('empty' => '_ _ _')
							))); ?>
        </div>
    </div>
	<div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup(
					$model, 'name', array('widgetOptions' => array(
						'htmlOptions' => array(
							'class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('name'),
							'data-content' => $model->getAttributeDescription('name')
					)))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->slugFieldGroup($model, 'slug', ['sourceAttribute' => 'name']);  ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'image', array('widgetOptions' => array('htmlOptions' => array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('image'), 'data-content' => $model->getAttributeDescription('image'))))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'meta_title', array('widgetOptions' => array('htmlOptions' => array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('meta_title'), 'data-content' => $model->getAttributeDescription('meta_title'))))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'meta_description', array('widgetOptions' => array('htmlOptions' => array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('meta_description'), 'data-content' => $model->getAttributeDescription('meta_description'))))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'meta_keywords', array('widgetOptions' => array('htmlOptions' => array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('meta_keywords'), 'data-content' => $model->getAttributeDescription('meta_keywords'))))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'status', array('widgetOptions' => array('htmlOptions' => array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'sort', array('widgetOptions' => array('htmlOptions' => array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('sort'), 'data-content' => $model->getAttributeDescription('sort'))))); ?>
        </div>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => Yii::t('multistore', 'Сохранить Типа организации и продолжить'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
            'label'      => Yii::t('multistore', 'Сохранить Типа организации и закрыть'),
        )
    ); ?>

<?php $this->endWidget(); ?>