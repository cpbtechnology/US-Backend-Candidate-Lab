<?php
/* @var $this NotesController */
/* @var $model Notes */

$this->breadcrumbs=array(
	'Notes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Notes', 'url'=>array('index')),
	array('label'=>'Manage Notes', 'url'=>array('admin')),
);
?>

<h1>Create Notes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>