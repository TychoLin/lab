<?php
define('DOC_ROOT', realpath(dirname(__FILE__).'/../'));

require DOC_ROOT.'/includes/functions.inc.php';
require DOC_ROOT.'/includes/db.inc.php';

$main_content_path = DOC_ROOT.'/templates/'.str_replace('.', '.tpl.', basename($_SERVER['PHP_SELF']));
define('MAIN_CONTENT_PATH', $main_content_path);

session_name('kasap');
session_start();

$auth = auth::getInstance();
?>