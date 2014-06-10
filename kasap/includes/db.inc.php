<?php
class db {
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

class user {
	public function load($id = -1, $limit = '', $offset = '') {
		$cond = '';
		if ($id != -1)
			$cond = " WHERE id=".(int)$id;
		if (($limit !== '') && ($offset !== '')) {
			$cond = " LIMIT $limit OFFSET $offset";
		}

		$sql = "SELECT id, email, gender, nickname FROM user".$cond;
		try {
			$ps = db::getPDO()->query($sql);
			return $ps->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function insert($item) {
		$columns = implode(',', array_keys($item));
		$params = array();
		foreach ($item as $k => $v) {
			$params[":$k"] = $v;
		}
		$named_params = implode(',', array_keys($params));
		try {
			$ps = db::getPDO()->prepare("INSERT INTO user($columns) VALUES($named_params)");
			$ps->execute($params);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function modify($item, $filter) {
		$front_named_params = $params = array();
		foreach ($item as $k => $v) {
			$front_named_params[] = $k.'=:'.$k;
			$params[":$k"] = $v;
		}
		$front_named_params = implode(',', $front_named_params);
		$back_named_params = array();
		foreach ($filter as $k => $v) {
			$back_named_params[] = "$k=:$k";
			$params[":$k"] = $v;
		}
		if (count($back_named_params) == 1) {
			$back_named_params = $back_named_params[0];
		} else if (count($back_named_params) > 1) {
			$back_named_params = implode(' AND ', $back_named_params);
		} else {
			return false;
		}
		try {
			$ps = db::getPDO()->prepare("UPDATE user SET $front_named_params WHERE $back_named_params");
			$ps->execute($params);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function delete($id) {
		$cond = '';
		if (is_array($id)) {
			if (count($id) == 1) {
				$cond = " id=".(int)$id;
			} else {
				$id = implode(',', $id);
				$cond = " id IN($id)";
			}
		} else if(is_string($id)) {
			$cond = " id=".(int)$id;
		} else {
			return false;
		}

		$sql = 'DELETE FROM USER WHERE'.$cond;
		try {
			$ps = db::getPDO()->prepare($sql);
			$ps->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function count() {
		$sql = "SELECT COUNT(*) FROM user";
		try {
			$ps = db::getPDO()->query($sql);
			return $ps->fetchColumn();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}

class auth {
	private static $_instance;

	public static function getInstance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function login($account, $password) {
		$sql = "SELECT id, email, gender, nickname FROM user WHERE email=:email AND pw=:pw";
		$params = array(
			':email' => $account,
			':pw' => md5($password)
		);
		try {
			$ps = db::getPDO()->prepare($sql);
			$ps->execute($params);
			$row = $ps->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		if ($row == false) {
			return false;
		} else {
			$_SESSION['user'] = $row;
			return true;
		}
	}
	
	public function isLogined() {
		if (isset($_SESSION['user'])) {
			return true;
		} else {
			return false;
		}
	}
	
	public function logout() {
		$_SESSION = array();
		redirect('login.php');
	}
	
	public function createUser($account, $password) {
		$sql = "SELECT COUNT(*) FROM user WHERE email=:email";
		$params = array(
			':email' => $account
		);
		try {
			$ps = db::getPDO()->prepare($sql);
			$ps->execute($params);
			$isExisted = $ps->fetchColumn();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		if ($isExisted > 0)
			return false;
		
		$user = new user();
		$item = array(
			'email' => $account,
			'pw' => md5($password),
		);
		$user->insert($item);
		return true;
	}
}
?>