<?php
class Auth {
	public function __construct() {
		session_name("drlight");
		session_start();
	}

	public function login($account, $pw) {
		if ($account == "admin" && $pw == "admin") {
			$_SESSION["logined"] = true;
			return true;
		} else {
			return false;
		}
	}

	public function isLogined() {
		if (isset($_SESSION["logined"]) && $_SESSION["logined"]) {
			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		}

		session_destroy();
		header("Location: login.php");
		exit();
	}
}
?>