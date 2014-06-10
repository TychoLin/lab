<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$item = array(
		'email' => $_POST['email'],
		'pw' => md5($_POST['pw']),
		'gender' => $_POST['gender'],
		'nickname' => $_POST['nickname']
	);
	$user = new user();
	$user->insert($item);
	// redirect('.');
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table>
	<tr>
		<th>column</th>
		<th>value</th>
	</tr>
	<tr>
		<td>email</td>
		<td><input type="text" name="email" /></td>
	</tr>
	<tr>
		<td>password</td>
		<td><input type="password" name="pw" /></td>
	</tr>
	<tr>
		<td>gender</td>
		<td>
			<input type="radio" id="men" name="gender" value="1" checked="checked" /><label for="men">men</label>
			<input type="radio" id="women" name="gender" value="2" /><label for="women">women</label>
		</td>
	</tr>
	<tr>
		<td>nickname</td>
		<td><input type="text" name="nickname" /></td>
	</tr>
</table>
<input type="submit" name="add" value="add" />
</form>