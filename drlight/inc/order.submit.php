<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
<form action="<?php echo $this->_postUrl; ?>" method="post" style="display: none;">
	<?php foreach ($data as $key => $value) { ?>
	<input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
	<?php } ?>
	<input type="submit" value="submit">
</form>
<script type="text/javascript">
$("form").submit();
</script>
</body>
</html>