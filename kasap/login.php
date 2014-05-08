<?php
require './includes/leading.inc.php';

if ($auth->isLogined())
	redirect('.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['login'])) {
		if($auth->login($_POST['email'], $_POST['pw']))
			redirect('.');
	} else if (isset($_POST['create'])) {
		$auth->createUser($_POST['email'], $_POST['pw']);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>hello world</title>
	</head>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<table>
				<tr>
					<td>email</td>
					<td><input type="text" name="email" /></td>
				</tr>
				<tr>
					<td>password</td>
					<td><input type="password" name="pw" /></td>
				</tr>
			</table>
			<input type="submit" name="login" value="login" />
			<input type="submit" name="create" value="create" />
		</form>
	</body>
</html>