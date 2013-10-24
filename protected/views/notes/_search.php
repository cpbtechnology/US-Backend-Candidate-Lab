<?php
/* @var $this NotesController */
/* @var $model Notes */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'tbl_notes_id'); ?>
		<?php echo $form->textField($model,'tbl_notes_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tbl_notes_title'); ?>
		<?php echo $form->textField($model,'tbl_notes_title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tbl_notes_description'); ?>
		<?php echo $form->textArea($model,'tbl_notes_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creator_id'); ?>
		<?php echo $form->textField($model,'creator_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->