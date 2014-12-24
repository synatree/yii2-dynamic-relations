<?php
	use synatree\dynamicrelations\SynatreeAsset;

	SynatreeAsset::register($this);
?>

<label class="form-control"><?= $title; ?></label>
<ul class="list-group" data-related-view="<?= $ajaxAddRoute; ?>">
	<li class="list-group-item">
		<a href="#" class="btn btn-success btn-sm add-dynamic-relation">
			<i class="glyphicon glyphicon-plus"></i> Add
		</a>
	</li>

<?php 
	foreach($collection as $model)
	{
?>
	<li class="list-group-item">
		<button type="button" class="close remove-dynamic-relation" aria-label="Remove"><span aria-hidden="true">&times;</span></button>		
		<div class="dynamic-relation-container">
			<?= $this->renderFile( $viewPath, [ 'model' => $model ]); ?>
		</div>
	</li>	
<?php
	}
?>
</ul>
