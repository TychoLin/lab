<?php
if (isset($_FILES["test"])) {
	foreach ($_FILES["test"]["error"] as $key => $error) {
		if ($error == UPLOAD_ERR_OK) {
			echo $_FILES["test"]["tmp_name"][$key];
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
<form action="file_upload.php" method="post" enctype="multipart/form-data">
	<input type="file" name="test[]" multiple>
	<input type="file" name="test[]" multiple>
	<input type="file" name="test[]" multiple>
	<input type="submit" value="submit">
</form>
<script type="text/javascript">
$(function () {
	$("input[type=file]:nth-child(2)").change(function (event) {
		var form_data = new FormData();
		var files = $(event.target).prop("files");
		$(files).each(function (index, elem) {
			form_data.append("test[]", elem);
		});

		$.ajax({
			type: "POST",
			url: "handle_upload_ajax.php",
			data: form_data,
			processData: false,
			contentType: false,
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = Math.floor((evt.loaded / evt.total) * 100);
						//Do something with upload progress
						console.log(percentComplete + "%");
					}
				}, false);
				//Download progress
				xhr.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = Math.floor((evt.loaded / evt.total) * 100);
						//Do something with download progress
						console.log(percentComplete + "%");
					}
				}, false);
				return xhr;
			},
			success: function (data) {
				console.log(data);
			}
		});
	});

	$("input[type=file]:nth-child(3)").change(function (event) {
		var data = "";
		var file_reader = new FileReader();
		file_reader.onload = function (e) {
			data = e.target.result;
			$.ajax({
				type: "PUT",
				url: "handle_upload_ajax.php",
				data: data,
				success: function (data) {
					console.log(data);
					$("body").append($("<img>").prop("src", data));
				}
			});
		};

		var files = $(event.target).prop("files");
		file_reader.readAsDataURL(files[0]);
		console.log(files);
	});
});
</script>
</body>
</html>