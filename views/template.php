<?php
	use synatree\dynamicrelations\SynatreeAsset;

	SynatreeAsset::register($this);
?>

<label class="form-control"><?= $title; ?></label>
<ul class="list-group">
<?php 
	foreach($collection as $model)
	{
?>
	<li class="list-group-item">
		<button type="button" class="close remove-dynamic-relation" aria-label="Remove"><span aria-hidden="true">&times;</span></button>		
		<?= $this->renderFile( $viewPath, [ 'model' => $model ]); ?>
	</li>	
<?php
	}
?>
	<li class="list-group-item">
		<a href="#" class="btn btn-success btn-sm">
			<i class="glyphicon glyphicon-plus"></i> Add
		</a>
	</li>
</ul>
