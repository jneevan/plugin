`<?php
include_once 'functions.php';
?>

<h3><a href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=all">Back to the list of galleries</a></h3>

<?php
$id = (int) $_GET['id'];
if ($id == 0) {
	exit(' Invalid id!');
}
if (!empty($_POST)) {
	if (isset($_POST['save'])) {
		$gal_name = getGalleryByName($_POST['name']);
		if ($gal_name) {//Check for the existence of the gallery with the same name
			if (($gal_name['name'] == $_POST['name']) && $gal_name['id'] == $id) {//If the name has not changed - save
				if (editGallery($id, $_POST['name'], $_POST['desc'], $_POST['img1'], $_POST['img2'], $_POST['img3'])) {
					echo '<h3> Successfully edited!</h3>';
					exit();
				}
			} elseif ($gal_name['name'] == $_POST['name']) {
				echo "<h3>Gallery with the same name already exists!</h3><br/></br/><h3><a class='btn btn-warning link' href='?page=gallery&c=edit&id=$id'>Try again</a></h3>";
				exit();
			}
		} else {//Otherwise, save
			if (editGallery($id, $_POST['name'], $_POST['desc'], $_POST['img1'], $_POST['img2'], $_POST['img3'])) {
				echo '<h3> Successfully edited!</h3>';
				exit();
			}
			$name = $_POST['name'];
			$desc = $_POST['desc'];
			$img1 = $_POST['img1'];
			$img2 = $_POST['img2'];
			$img3 = $_POST['img3'];
		}
	}
} else {
	$galleryplug = getGalleryById($id);
	$name = $galleryplug['name'];
	$desc = $galleryplug['desc'];
	$img1 = $galleryplug['img1'];
	$img2 = $galleryplug['img2'];
	$img3 = $galleryplug['img3'];
}
?>

<div class="col-md-12">
	<div class="col-md-12 title">
		<h3> Editing:</h3>
	</div>
	<div class="col-md-12">
		<form method="post" class="edit_form" enctype="multipart/form-data">
			<label for="name">Title:&nbsp;&nbsp;</label>
			<input type="text" id="name" name="name" placeholder="Title" required value="<?= $name ?>"/><br/><br/>
			<label for="desc"> Short description:&nbsp;&nbsp;</label>
			<textarea id="desc" name="desc" placeholder=" Short description" rows="2" cols="40" required><?= $desc ?></textarea><br/><br/>
			<label for="img1">Picture 1 (Old - <?= '"' . $img1 . '"' ?>):&nbsp;&nbsp;</label>
			<input type="file" id="img1" name="img1" placeholder="Image 1" size="40" accept="image/jpeg,image/png" required value="<?= $img1 ?>"/><br/><br/>
			<label for="img2">Picture 2 (Old - <?= '"' . $img2 . '"' ?>):&nbsp;&nbsp;</label>
			<input type="file" id="img2" name="img2" placeholder="Image 2" size="40" accept="image/jpeg,image/png" required value="<?= $img2 ?>"/><br/><br/>
			<label for="img3">Picture 3 (Old - <?= '"' . $img3 . '"' ?>):&nbsp;&nbsp;</label>
			<input type="file" id="img3" name="img3" placeholder="Image 3" size="40" accept="image/jpeg,image/png" required value="<?= $img3 ?>"/><br/><br/>
			<button name="save" class="btn btn-success"> Save</button>
		</form>
	</div>
</div>