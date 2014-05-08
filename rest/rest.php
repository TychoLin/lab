<?php
function exception_error_handler($errno, $errstr, $errfile, $errline) {
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");

class Control {
	protected static $statusCode = 200;
	private static $status = array(
		200 => "OK",
		201 => "Created",
		204 => "No Content",
		400 => "Bad Request",
		401 => "Unauthorized",
		403 => "Forbidden",
		404 => "Not Found",
		405 => "Method Not Allowed",
		500 => "Internal Server Error",
		503 => "Service Unavailable"
	);

	public static function response() {
		$statusCode = self::$statusCode;
		$message = self::$status[$statusCode];
		header("HTTP/1.1 {$statusCode} {$message}");
		echo "{$statusCode} {$message}";
		exit;
	}
}

class User extends Control {
	public function post() {
		self::$statusCode = 201;
		// ...
	}

	public function get() {
		// ...
	}

	public function put() {
		self::$statusCode = 204;
		// ...
	}

	public function delete() {
		self::$statusCode = 204;
		// ...
	}
}

class RestControl extends Control {
	private $control = false;
	private $segments = false;

	public function __construct() {
		if (!isset($_SERVER["PATH_INFO"])) {
			return;
		}

		$this->segments = explode("/", $_SERVER["PATH_INFO"]);
		array_shift($this->segments);

		$controlName = ucfirst(array_shift($this->segments));
		if (!class_exists($controlName)) {
			$controlFilePath = "$controlName.php";
			if (file_exists($controlFilePath)) {
				require_once($controlFilePath);
			} else {
				self::$statusCode = 404;
			}
		}
		$this->control = new $controlName;
	}

	public function run() {
		if ($this->control === false) {
			return $this->index();
		}

		if (empty($this->segments)) {
			$this->control->index();
		}

		$method = ucfirst(strtolower($_SERVER["REQUEST_METHOD"]));
		if (!method_exists($this->control, $method)) {
			self::$statusCode = 405;
		}

		$args = $this->segments;
		$this->control->$method($args);
		self::response();
	}
}

$api = new RestControl();
$api->run();
?>