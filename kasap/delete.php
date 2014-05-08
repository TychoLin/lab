<?php
require './includes/leading.inc.php';

if(($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['user_id']))) {
	$user = new user();
	$user->delete($_GET['user_id']);
	redirect('.');
}
?>