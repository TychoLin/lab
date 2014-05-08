<?php
$user = new user();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['modify'])) {
		$item = array(
			'email' => $_POST['email'],
			'pw' => md5($_POST['pw']),
			'gender' => $_POST['gender'],
			'nickname' => $_POST['nickname']
		);
		$user->modify($item, array('id' => $_POST['user_id']));
	} else {
		$user->delete($_POST['user_id']);
	}
	redirect('.');
} else if(isset($_GET['user_id'])) {
	$row = $user->load($_GET['user_id']);
} else {
	redirect('.');
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
		<td><input type="text" name="email" value="<?php echo $row[0]['email'] ?>" /></td>
	</tr>
	<tr>
		<td>password</td>
		<td><input type="password" name="pw" /></td>
	</tr>
	<tr>
		<td>gender</td>
		<td>
			<?php ($row[0]['gender'] == 'M') ? $checked = array('M' => 'checked="checked"', 'W' => '') : $checked = array('M' => '', 'W' => 'checked="checked"') ?>
			<input type="radio" id="men" name="gender" value="M" <?php echo $checked['M'] ?> /><label for="men">men</label>
			<input type="radio" id="women" name="gender" value="W" <?php echo $checked['W'] ?> /><label for="women">women</label>
		</td>
	</tr>
	<tr>
		<td>nickname</td>
		<td><input type="text" name="nickname" value="<?php echo $row[0]['nickname'] ?>" /></td>
	</tr>
</table>
<input type="submit" name="modify" value="modify" />
<input type="submit" name="delete" value="delete" />
<input type="hidden" name="user_id" value="<?php echo $row[0]['id'] ?>" />
</form>