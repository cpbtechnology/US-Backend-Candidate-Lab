<?php
/* @var $this NotesController */
/* @var $model Notes */

$this->breadcrumbs=array(
	'Notes'=>array('index'),
	$model->tbl_notes_id,
);

$this->menu=array(
	array('label'=>'List Notes', 'url'=>array('index')),
	array('label'=>'Create Notes', 'url'=>array('create')),
	array('label'=>'Update Notes', 'url'=>array('update', 'id'=>$model->tbl_notes_id)),
	array('label'=>'Delete Notes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->tbl_notes_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notes', 'url'=>array('admin')),
);
?>

<h1>View Notes #<?php echo $model->tbl_notes_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'tbl_notes_id',
		'tbl_notes_title',
		'tbl_notes_description',
		'creator_id',
	),
)); ?>
