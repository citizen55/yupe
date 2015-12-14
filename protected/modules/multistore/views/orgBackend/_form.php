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
 *   @var $model Org
 *   @var $form TbActiveForm
 *   @var $this OrgController
 **/
$form = $this->beginWidget(
    'yupe\widgets\ActiveForm', array(
        'id'                     => 'org-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => array('class' => 'well'),
    )
);
?>

<div class="alert alert-info">
    <?php echo Yii::t('multistore', 'Поля, отмеченные'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('multistore', 'обязательны.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textFieldGroup(
					$model, 'name', array(
						'widgetOptions' => array(
							'htmlOptions' => array(
								'class' => 'popover-help',
								'data-original-title' => $model->getAttributeLabel('name'),
								'data-content' => $model->getAttributeDescription('name')
							)
						)
					)
				); ?>
        </div>
    </div>
	<div class="row">
        <div class="col-sm-5">
            <?php echo $form->slugFieldGroup(
					$model, 'slug', ['sourceAttribute' => 'name']);
			?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textFieldGroup(
					$model, 'image', array(
						'widgetOptions' => array(
							'htmlOptions' => array(
								'class' => 'popover-help',
								'data-original-title' => $model->getAttributeLabel('image'),
								'data-content' => $model->getAttributeDescription('image')
							)
						)
					)
				);
			?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->dropDownListGroup(
					$model, 'user_id', array(
						'widgetOptions' => array(
							'data' => CHtml::listData(User::model()->findAll(), 'id', 'nick_name'),
							'htmlOptions' => ['empty' => '---']
						)
					)
				);
			?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->dropDownListGroup(
					$model, 'type_id', array(
						'widgetOptions' => array(
							'data' => CHtml::listData(TypeOrg::model()->findAll(), 'id', 'name'),
							'htmlOptions' => ['empty' => '---'],
							))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textFieldGroup(
					$model, 'phone_1', array(
						'widgetOptions' => array(
							'htmlOptions' => array(
								'class' => 'popover-help',
								'data-original-title' => $model->getAttributeLabel('phone_1'),
								'data-content' => $model->getAttributeDescription('phone_1')
					))));
			?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textFieldGroup(
					$model, 'phone_2', array(
						'widgetOptions' => array(
							'htmlOptions' => array(
								'class' => 'popover-help',
								'data-original-title' => $model->getAttributeLabel('phone_2'),
								'data-content' => $model->getAttributeDescription('phone_2')
					)))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textFieldGroup(
					$model, 'fax', array(
						'widgetOptions' => array(
							'htmlOptions' => array(
								'class' => 'popover-help',
								'data-original-title' => $model->getAttributeLabel('fax'),
								'data-content' => $model->getAttributeDescription('fax')
					)))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textFieldGroup(
					$model, 'location', array(
						'widgetOptions' => array(
							'htmlOptions' => array(
								'class' => 'popover-help',
								'data-original-title' => $model->getAttributeLabel('location'),
								'data-content' => $model->getAttributeDescription('location')
					)))); ?>
        </div>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => Yii::t('multistore', 'Сохранить организации и продолжить'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
            'label'      => Yii::t('multistore', 'Сохранить организации и закрыть'),
        )
    ); ?>

<?php $this->endWidget(); ?>