<?php
include_once 'functions.php';
?>

<h3><a href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=all">Back to the list of galleries</a></h3>

<?php
if (!empty($_POST)) {
	$galleries = getAllGalleries();
	if (count($galleries) != 0) {//If the list of galleries is not empty, then go by adding a new
		$gal_name = getGalleryByName($_POST['name']);
		if ($gal_name) {//Check for the existence of the gallery with the same name. If there is - do not create
			echo "<h3> Gallery with the title already exists!</h3><br/></br/><h3><a class='btn btn-warning link' href='?page=gallery&c=add'> Try again</a></h3>";
			exit();
		} else {//Если нет -создаем
			if (addGallery($_POST['name'], $_POST['desc'], $_POST['img1'], $_POST['img2'], $_POST['img3'])) {
				$galleryplug = getGalleryByName($_POST['name']);
				$shortcode = '[ac_gallery id="' . $galleryplug['id'] . '"]';
				addShortcode($galleryplug['id'], $shortcode);
				echo '<h3>Shortcode to insert:&nbsp;&nbsp;&nbsp;<strong>' . $shortcode . '</strong></h3<br/><br/>';
				exit('Gallery successfully created!');
			}
		}
	} else {//If empty, then naturally create without checking the name
		if (addGallery($_POST['name'], $_POST['desc'], $_POST['img1'], $_POST['img2'], $_POST['img3'])) {
			$galleryplug = getGalleryByName($_POST['name']);
			$shortcode = '[ac_gallery id="' . $galleryplug['id'] . '"]';
			addShortcode($galleryplug['id'], $shortcode);
			echo '<h3>Shortcode to insert:&nbsp;&nbsp;&nbsp;<strong>' . $shortcode . '</strong></h3<br/><br/>';
			exit('Gallery successfully created!');
		}
	}
}
?>

<div class="col-md-12">
	<div class="col-md-12 title">
		<h3> New Gallery:</h3>
	</div>
	<div class="col-md-12">
		<form method="post" class="add_form" enctype="multipart/form-data">
			<label for="name"> Title:&nbsp;&nbsp;</label>
			<input type="text" id="name" name="name" placeholder=" Title" required/><br/><br/>
			<label for="desc">  Short description:&nbsp;&nbsp;</label>
			<textarea id="desc" name="desc" placeholder="  Short description" rows="2" cols="40" required></textarea><br/><br/>
			<label for="img1"> 1:&nbsp;&nbsp;</label>
			<input type="file" id="img1" name="img1" accept="image/jpeg,image/png" required/><br/><br/>
			<label for="img2"> 2 :&nbsp;&nbsp;</label>
			<input type="file" id="img2" name="img2" accept="image/jpeg,image/png" required/><br/><br/>
			<label for="img3"> 3 :&nbsp;&nbsp;</label>
			<input type="file" id="img3" name="img3" accept="image/jpeg,image/png" required/><br/><br/>
			<input type="hidden" name="hidden" value="<?= $galleryplug['id'] ?>"/>
			<button name="create" class="btn btn-success">Create</button>
		</form>
	</div>
</div>