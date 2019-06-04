<?php
include_once 'functions.php';
$allGallery = getAllGalleries();
if(isset($_POST['delete'])){
	$id = $_POST['hidden'];
	if(deleteGallery($id)){
		echo '<h3><a href="' . $_SERVER['PHP_SELF'] . '?page=gallery&c=all' . '">Back to the list of galleries</a></h3>';
		echo '<h3> Gallery deleted!</h3>';
		exit();
	}
}
?>

<div class="col-md-12">
	<?php if(count($allGallery) == 0): ?>
		<div class="col-md-12 title">
			<h1>The list of galleries is empty. Create a gallery!</h1>
		</div>
		<div class="col-md-12 cr">
			<a class="btn btn-info link" href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=add">Create New Gallery</a>
		</div>
	<?php else: ?>
		<div class="col-md-12 title">
			<h1>List of galleries</h1>
		</div>
		<div class="col-md-12 cr">
			<a class="btn btn-info link" href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=add">Create New Gallery</a>
		</div>
		<div class="col-md-12">
			<table class="table table-hover table-bordered" id="table">
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
						<th>Title</th>
						<th>Shortcode</th>
						<th>Operations</th>
					</tr>
				</thead>
				<tbody>
				<?php $count = 1; ?>
				<?php foreach($allGallery as $galleryplug): ?>
				<tr>
					<td><?= $count; ?></td>
					<td><?= $galleryplug['id'] ?></td>
					<td><?= $galleryplug['name'] ?></td>
					<td><?= $galleryplug['shortcode'] ?></td>
					<td>
						<a class="btn btn-primary link" href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=edit&id=<?= $galleryplug['id'] ?>">Edit</a><br/><br/>
						<form method="post">
							<input type="hidden" name="hidden" value="<?= $galleryplug['id'] ?>"/>
							<button name="delete" class="btn btn-inverse">Delete</button>
						</form>
					</td>
				</tr>
				<?php $count++; ?>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>	
	<?php endif; ?>
</div>