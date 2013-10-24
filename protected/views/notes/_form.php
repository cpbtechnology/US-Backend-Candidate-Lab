<?php
/* @var $this NotesController */
/* @var $model Notes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tbl_notes_title'); ?>
		<?php echo $form->textField($model,'tbl_notes_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tbl_notes_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tbl_notes_description'); ?>
		<?php echo $form->textArea($model,'tbl_notes_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'tbl_notes_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creator_id'); ?>
		<?php echo $form->textField($model,'creator_id'); ?>
		<?php echo $form->error($model,'creator_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->