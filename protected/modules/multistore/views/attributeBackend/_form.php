<?php
/**
 * @var $this AttributeBackendController
 * @var $model Attribute
 * @var $form \yupe\widgets\ActiveForm
 */
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('multistore')->getAssetsUrl() . '/js/jquery-sortable.js');
?>

<?php
/**
 * @var $model Attribute
 */

$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id'                     => 'attribute-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('MultistoreModule.multistore', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('MultistoreModule.multistore', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'group_id',
            [
                'widgetOptions' => [
                    'data'        => AttributeGroup::model()->getFormattedList(),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            [
                'widgetOptions' => [
                    'data'        => $model->getTypesList(),
                    'htmlOptions' => [
                        'empty' => '---',
                        'id'    => 'attribute-type',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>


<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'title'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->slugFieldGroup($model, 'name', ['sourceAttribute' => 'title']); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'unit'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->checkBoxGroup($model, 'required'); ?>
    </div>
</div>


<div class="row">
    <div id="options" class="<?php echo !in_array($model->type, Attribute::getTypesWithOptions()) ? 'hidden' : ''; ?> col-sm-5">
        <div class="row form-group">
            <div class="col-sm-12">
                <?php echo Yii::t("MultistoreModule.attr", "Each option value must be on a new line."); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo CHtml::activeTextArea($model, 'rawOptions', ['rows' => 10, 'class' => 'form-control']); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#attribute-type').change(function () {
            if ($.inArray(parseInt($(this).val()), [<?php echo join(',', Attribute::getTypesWithOptions());?>]) >= 0) {
                $('#options').removeClass('hidden');
            }
            else {
                $('#options').addClass('hidden');
            }
        });
    });
</script>

<br/><br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('MultistoreModule.attr', 'Add attribute and continue') : Yii::t('MultistoreModule.attr', 'Save attribute and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('MultistoreModule.attr', 'Add attribute and close') : Yii::t('MultistoreModule.attr', 'Save attribute and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
