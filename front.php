<?php
include_once 'functions.php';
$galleryplug = getGalleryById($id);
$path_array  = wp_upload_dir();
$path = str_replace('\\', '/', $path_array['url']);
?>

<div class="gallery">
	<h2><?= $galleryplug['name'] ?></h2>
	<p><?= $galleryplug['desc'] ?></p>
	<a href="<?= $path . '/' . $galleryplug['img1'] ?>" data-lightbox="roadtrip"><img class="image" src="<?= $path . '/' . $galleryplug['img1'] ?>" alt="img1"/></a>
	<a href="<?= $path . '/' . $galleryplug['img2'] ?>" data-lightbox="roadtrip"><img class="image" src="<?= $path . '/' . $galleryplug['img2'] ?>" alt="img2"/></a>
	<a href="<?= $path . '/' . $galleryplug['img3'] ?>" data-lightbox="roadtrip"><img class="image" src="<?= $path . '/' . $galleryplug['img3'] ?>" alt="img3"/></a>
</div>