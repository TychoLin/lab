<?php
require_once("common.inc.php");

$auth = new Auth();
if (!$auth->isLogined()) {
	header("Location: login.php");
	exit();
}

// controller
$views = array("article");
$view_name = "article";
if (isset($_GET["v"]) && in_array($_GET["v"], $views)) {
	$view_name = $_GET["v"];
}

define("VIEW_PATH", "$view_name.tpl.php");
$view_url = $_SERVER["PHP_SELF"]."?v=$view_name";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>DRLIGHT 管理後台</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<style type="text/css">
table {
	border-collapse: collapse;
	width: 100%;
	table-layout: fixed;
}

td, th {
	border: 1px solid black;
	padding: 0.5em;
	overflow: hidden;
}

nav {
	margin-bottom: 0.5em;
}

nav a {
	margin: 0.5em;
}

.container {
	width: 60%;
	margin: auto;
}
</style>
</head>
<body>
	<div class="container">
		<h1>DRLIGHT 管理後台</h1>
		<nav>
			<a href="?v=article">文章列表</a>
			<a href="?v=article&action=create">新增文章</a>
			<a href="logout.php">logout</a>
		</nav>
		<?php require_once(VIEW_PATH); ?>
		<div style="clear: both;"></div>
	</div>
</body>
</html>