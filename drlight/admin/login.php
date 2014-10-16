<?php
require_once("Auth.class.php");

$auth = new Auth();

if ($auth->isLogined()) {
	header("Location: index.php");
	exit();
}

if (isset($_POST["account"], $_POST["pw"])) {
	if ($auth->login($_POST["account"], $_POST["pw"])) {
		header("Location: index.php");
		exit();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
.container {
	width: 50%;
	margin: auto;
}
</style>
</head>
<body>
	<div class="container">
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
			<fieldset>
				<legend>DRLIGHT 管理後台</legend>
				<label for="account">帳號：</label>
				<input type="text" name="account" autofocus>
				<label for="pw">密碼：</label>
				<input type="password" name="pw">
				<input type="submit" value="送出">
			</fieldset>
		</form>
	</div>
</body>
</html>