<?php
/* @var $this NotesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Notes',
);

$this->menu=array(
	array('label'=>'Create Notes', 'url'=>array('create')),
	array('label'=>'Manage Notes', 'url'=>array('admin')),
);
?>

<h1>Notes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
