<?php
function pagination($pageAmount, $pageNumber, $range = 7) {
	if ($pageAmount <= 1)
		return;
	if ($pageNumber != 1) {
		$prev = $pageNumber - 1;
		echo "<span><a href=\"?p=$prev\">prev</a></span>";
	}
	if ($pageNumber > $range) {
		$pageIndex = $pageNumber - $range;
	} else {
		$pageIndex = 1;
	}
	if (($pageAmount - $pageNumber) > $range) {
		$endIndex = $pageNumber + $range;
	} else {
		$endIndex = $pageAmount;
	}
	for (;$pageIndex <= $endIndex; $pageIndex++) {
		if ($pageIndex == $pageNumber) {
			echo "<span>$pageIndex</span>";
		} else {
			echo "<span><a href=\"?p=$pageIndex\">$pageIndex</a></span>";
		}
	}
	if ($pageNumber != $pageAmount) {
		$next = $pageNumber + 1;
		echo "<span><a href=\"?p=$next\">next</a></span>";
	}
}

if (!$auth->isLogined())
	redirect('login.php');

$user = new user();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$user->delete(explode(',', $_POST['user_id']));
}

// pagination setting
$amount = $user->count();
$limit = 3;
$pageAmount = ceil($amount/$limit);
if (isset($_GET['p']) && ($_GET['p'] > 0) && ($_GET['p'] <= $pageAmount)) {
	$pageNumber = $_GET['p'];
} else {
	$pageNumber = 1;
}
$offset = ($pageNumber - 1) * $limit;
$rows = $user->load(-1, $limit, $offset);
?>
<div id="pagination">
<?php pagination($pageAmount, $pageNumber); ?>
</div>
<form id="index" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table>
	<tr>
		<th><input type="checkbox" id="cb_mam" name="cb_mam" /></th>
		<th>email</th>
		<th>gender</th>
		<th>nickname</th>
		<th>function</th>
		<th>function</th>
	</tr>
	<?php foreach($rows as $row) { ?>
	<tr>
		<td><input type="checkbox" id="item_<?php echo $row['id'] ?>" name="item" /></td>
		<td><?php echo $row['email'] ?></td>
		<td><?php echo $row['gender'] ?></td>
		<td><?php echo $row['nickname'] ?></td>
		<td><a href="modify.php?user_id=<?php echo $row['id'] ?>">modify</a></td>
		<td><a href="delete.php?user_id=<?php echo $row['id'] ?>">delete</a></td>
	</tr>
	<?php } ?>
</table>
<input type="submit" name="submit" value="delete" />
<input type="hidden" id="user_id" name="user_id" />
</form>