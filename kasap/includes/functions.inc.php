<?php
function redirect($url = '') {
	if(empty($url)) $url = DOC_ROOT;
	header("Location: $url");
	exit;
}
?>