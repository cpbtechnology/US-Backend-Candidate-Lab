<?php
/* @var $this NotesController */
/* @var $data Notes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_notes_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tbl_notes_id), array('view', 'id'=>$data->tbl_notes_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_notes_title')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_notes_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_notes_description')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_notes_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creator_id')); ?>:</b>
	<?php echo CHtml::encode($data->creator_id); ?>
	<br />


</div>