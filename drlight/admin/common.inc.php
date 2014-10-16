<?php
require_once("../inc/db.inc.php");
require_once("../inc/NotORM.php");
require_once("Auth.class.php");

define("SELF_URL", $_SERVER["PHP_SELF"]."?".http_build_query($_GET));
?>