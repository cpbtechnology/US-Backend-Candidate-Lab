<?php
/* @var $this NotesController */
/* @var $model Notes */

$this->breadcrumbs=array(
	'Notes'=>array('index'),
	$model->tbl_notes_id=>array('view','id'=>$model->tbl_notes_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Notes', 'url'=>array('index')),
	array('label'=>'Create Notes', 'url'=>array('create')),
	array('label'=>'View Notes', 'url'=>array('view', 'id'=>$model->tbl_notes_id)),
	array('label'=>'Manage Notes', 'url'=>array('admin')),
);
?>

<h1>Update Notes <?php echo $model->tbl_notes_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>