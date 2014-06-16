<?php
class DB {
	private static $_db;

	private function __construct() {
		try {
			self::$_db = new PDO('mysql:dbname=labdb;host=localhost', 'root', '9999');
			self::$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo 'Connection failed: '.$e->getMessage();
		}
	}
	
	public static function getPDO() {
		if (is_null(self::$_db)) {
			new self();
		}
		return self::$_db;
	}
}

class RecordModel {
	private $_tableName = '';
	private $_primaryKeyName = '';

	public function __construct($tableName, $primaryKeyName) {
		$this->_tableName = $tableName;
		$this->_primaryKeyName = $primaryKeyName;
	}

	public function create($record) {
		$fields = implode(',', array_keys($record));
		$params = array();
		foreach ($record as $k => $v) {
			$params[":$k"] = $v;
		}
		$named_params = implode(',', array_keys($params));

		$sql = "INSERT INTO {$this->_tableName}($fields) VALUES($named_params)";
		try {
			$ps = DB::getPDO()->prepare($sql);
			$ps->execute($params);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}

class TblCategory extends RecordModel {
	public function __construct() {
		parent::__construct('tblCategory', 'category_id');
	}
}

// $tc = new TblCategory();
// for ($i = 0; $i < 3; $i++) {
// 	$record = array(
// 		"category_parent_id" => 3,
// 		"category_name" => chr(99).($i + 1),
// 		"category_rank" => 1,

// 	);
// 	$tc->create($record);
// }


?>