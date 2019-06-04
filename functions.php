<?php

# Getting a list of all galleries
function getAllGalleries() {
	global $wpdb;
	$galleryplug = $wpdb->prefix . 'gallery';
	$query = "SELECT * FROM $galleryplug";
	return $wpdb->get_results($query, ARRAY_A);
}

# Getting a gallery'id'
function getGalleryById($id) {
	global $wpdb;
	$galleryplug = $wpdb->prefix . 'gallery';
	$gal_id = "SELECT * FROM $galleryplug WHERE id='%d'";
	$query = $wpdb->prepare($gal_id, $id);
	return $wpdb->get_row($query, ARRAY_A);
}

# Getting a gallery'name'
function getGalleryByName($name) {
	global $wpdb;
	$galleryplug = $wpdb->prefix . 'gallery';
	$gal_name = "SELECT * FROM $galleryplug WHERE name='%s'";
	$query = $wpdb->prepare($gal_name, $name);
	return $wpdb->get_row($query, ARRAY_A);
}

# Adding a new gallery
function addGallery($name, $desc, $img1, $img2, $img3) {
	global $wpdb;
	$name = trim($name);
	$desc = trim($desc);
	for($i=1; $i<=3; $i++){
		if(is_uploaded_file($_FILES['img' . $i]['tmp_name'])){
			$path_array  = wp_upload_dir();
			$path = str_replace('\\', '/', $path_array['path']);
			$img_name = $_FILES['img' . $i]['name'];
			$uploads = move_uploaded_file($_FILES['img' . $i]["tmp_name"], $path. "/" . $img_name);
			echo " Picture " .$i. " saved to: " . $path . "/"  . $img_name . '<br/>';
			if(!$uploads){
				echo 'Error!';
				return false;
			}
		}
	}
	$img1 = $_FILES['img1']['name'];
	$img2 = $_FILES['img2']['name'];
	$img3 = $_FILES['img3']['name'];
	$galleryplug = $wpdb->prefix . 'gallery';
	$gal = "INSERT INTO $galleryplug (`name`, `desc`, `img1`, `img2`, `img3`) VALUES ('%s', '%s', '%s', '%s', '%s')";
	$query = $wpdb->prepare($gal, $name, $desc, $img1, $img2, $img3);
	$result = $wpdb->query($query);
	if ($result === false) {
		exit('Error!');
	}
	return true;
}


#Add shortcode
function addShortcode($id, $shortcode) {
	global $wpdb;
	$shortcode = trim($shortcode);
	$galleryplug = $wpdb->prefix . 'gallery';
	$sc = "UPDATE $galleryplug SET `shortcode`='%s' WHERE id='%d'";
	$query = $wpdb->prepare($sc, $shortcode, $id);
	$result = $wpdb->query($query);
	if ($result === false) {
		exit('Error!');
	}
	return true;
}

#Editing gallery
function editGallery($id, $name, $desc, $img1, $img2, $img3) {
	global $wpdb;
	$name = trim($name);
	$desc = trim($desc);
	$img1 = $_FILES['img1']['name'];
	$img2 = $_FILES['img2']['name'];
	$img3 = $_FILES['img3']['name'];
	for($i=1; $i<=3; $i++){
		if(is_uploaded_file($_FILES['img' . $i]['tmp_name'])){
			$path_array  = wp_upload_dir();
			$path = str_replace('\\', '/', $path_array['path']);
			$img_name = $_FILES['img' . $i]['name'];
			$uploads = move_uploaded_file($_FILES['img' . $i]["tmp_name"], $path. "/" . $img_name);
			echo " Picture " .$i. " 3: " . $path . "/"  . $img_name . '<br/>';
			if(!$uploads){
				echo 'error!';
				return false;
			}
		}
	}
	$galleryplug = $wpdb->prefix . 'gallery';
	$gal = "UPDATE $galleryplug SET `name`='%s', `desc`='%s', `img1`='%s', `img2`='%s', `img3`='%s' WHERE id='%d'";
	$query = $wpdb->prepare($gal, $name, $desc, $img1, $img2, $img3, $id);
	$result = $wpdb->query($query);
	if ($result === false) {
		exit('Error!');
	}
	return true;
}

#Delete gallery
function deleteGallery($id) {
	global $wpdb;
	$galleryplug = $wpdb->prefix . 'gallery';
	$del = "DELETE FROM $galleryplug WHERE id='%d'";
	$query = $wpdb->prepare($del, $id);
	return $wpdb->query($query);
}


