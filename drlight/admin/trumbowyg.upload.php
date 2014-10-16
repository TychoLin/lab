<?php
function resize_image($filename, $max_width, $max_height) {
	list($orig_width, $orig_height) = getimagesize($filename);
	$image_type = exif_imagetype($filename);

	$width = $orig_width;
	$height = $orig_height;

	// taller
	if ($height > $max_height) {
		$width = ($max_height / $height) * $width;
		$height = $max_height;
	}

	// wider
	if ($width > $max_width) {
		$height = ($max_width / $width) * $height;
		$width = $max_width;
	}

	$dst_image = imagecreatetruecolor($width, $height);

	// preserve transparency
	if ($image_type == IMAGETYPE_GIF || $image_type == IMAGETYPE_PNG) {
		imagecolortransparent($dst_image, imagecolorallocatealpha($dst_image, 0, 0, 0, 127));
		imagealphablending($dst_image, false);
		imagesavealpha($dst_image, true);
	}

	if ($image_type == IMAGETYPE_GIF) {
		$src_image = imagecreatefromgif($filename);
	} else if ($image_type == IMAGETYPE_JPEG) {
		$src_image = imagecreatefromjpeg($filename);
	} else if ($image_type == IMAGETYPE_PNG) {
		$src_image = imagecreatefrompng($filename);
	}

	imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

	if ($image_type == IMAGETYPE_GIF) {
		imagegif($dst_image, $filename);
	} else if ($image_type == IMAGETYPE_JPEG) {
		imagejpeg($dst_image, $filename);
	} else if ($image_type == IMAGETYPE_PNG) {
		imagepng($dst_image, $filename);
	}
}

try {
	if (count($_FILES) == 1) {
		$upload_dir_path = "upload/article";
		$absolute_upload_dir_path = __DIR__."/../$upload_dir_path";
		$prefix = "drlight_";

		if (!is_dir($absolute_upload_dir_path) && !mkdir($absolute_upload_dir_path, 0775, true)) {
			throw new Exception("fileError");
		}

		$file = array_shift($_FILES);

		if ($file["error"] == UPLOAD_ERR_OK) {
			$tmp_name = $file["tmp_name"];
			if (!in_array(exif_imagetype($tmp_name), array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
				throw new Exception("fileError");
			}

			list($width, $height) = getimagesize($tmp_name);
			resize_image($tmp_name, 768, $height);

			$name = $file["name"];
			$extension = pathinfo($name, PATHINFO_EXTENSION);
			$tmp_file_name = tempnam($absolute_upload_dir_path, $prefix);
			$new_tmp_file_name = $tmp_file_name.".$extension";
			rename($tmp_file_name, $new_tmp_file_name);
			if (move_uploaded_file($tmp_name, $new_tmp_file_name)) {
				echo json_encode(array("message" => "uploadSuccess", "file" => "http://".$_SERVER["HTTP_HOST"]."/drlight/$upload_dir_path/".basename($new_tmp_file_name)));
			} else {
				throw new Exception("fileError");
			}
		} else {
			throw new Exception("uploadError");
		}
	} else {
		throw new Exception("uploadError");
	}
} catch (Exception $e) {
	echo json_encode(array("message" => $e->getMessage()));
}
?>