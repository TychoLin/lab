<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>hello world</title>
		<script type="text/javascript" src="common.js"></script>
		<style type="text/css">
			body {
				font: 12pt "Lucida Grande", Lucida, Verdana, sans-serif;
				/*background-color: #334466;
				color: #bbccdd;*/
			}

			a:link, a:visited {
				text-decoration: none;
				color: #cca299;
			}

			a:hover, a:active {
				text-decoration: underline;
			}

			table {
				border-collapse: collapse;
			}

			table, td, th {
				border: 1px solid #6688bb;
			}
			
			td, th {
				padding: 0.6em;
			}
			
			hr {
				visibility: hidden;
			}

			#container {
				width: 900px;
				margin: auto;
			}

			#header {
				padding: 1em;
			}

			#content {
			}
			
			#left-col, #right-col {
				padding: 1em 0;
			}

			#left-col {
				float: left;
				width: 20%;
			}
			
			#left-col a {
				background-color: #4466aa;
				display: block;
				width: 70%;
				padding: 0.4em 0.6em;
				border-right: 10px solid #cca299;
				margin-bottom: 1px;
			}
			
			#left-col a:hover, #left-col a:active {
				margin-left: 10px;
			}

			#right-col {
				float: right;
				width: 76%;
			}
			
			#pagination span {
				margin-right: 0.5em;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<a href=".">home</a>
				<a href="login.php">login</a>
				<a href="logout.php">logout</a>
			</div>
			<div id="content">
				<div id="left-col">
					<a href="add.php">add user</a>
					<a href="add.php">add user</a>
					<a href="add.php">add user</a>
					<a href="add.php">add user</a>
				</div>
				<div id="right-col">
					<?php require MAIN_CONTENT_PATH; ?>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
	</body>
</html>
<?php ob_end_flush(); ?>