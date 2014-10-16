<?php
class DB {
	private static $_db;
	private static $_dbStores = array(
		"drlight" => array(
			"dsn" => "mysql:host=localhost;dbname=drlight",
			"username" => "root",
			"password" => "9999",
			"options" => array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
			),
		),
	);

	private function __construct($database) {
		$reflectionObj = new ReflectionClass("PDO");
		self::$_db[$database] = $reflectionObj->newInstanceArgs(self::$_dbStores[$database]);
		self::$_db[$database]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public static function getPDO($database) {
		if (!isset(self::$_db[$database])) {
			new self($database);
		}
		return self::$_db[$database];
	}
}
?>