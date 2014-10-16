<?php
class Allpay {
	private $_postUrl = "";
	private $_merchantID = "";
	private $_hashKey = "";
	private $_hashIV = "";

	public function __construct($config = array("debug" => false)) {
		if ($config["debug"]) {
			$this->_postUrl = "http://payment-stage.allpay.com.tw/Cashier/AioCheckOut";
			$this->_merchantID = "2000132";
			$this->_hashKey = "5294y06JbISpM5x9";
			$this->_hashIV = "v77hoKGq4kWxNNIS";
		} else {
			$this->_postUrl = "http://payment.allpay.com.tw/Cashier/AioCheckOut";
			$this->_merchantID = "1061026";
			$this->_hashKey = "KBuc32fZ1naRrCOT";
			$this->_hashIV = "0Bl35tS13hFo9BLf";
		}
	}

	/**
	 * create order for allpay api
	 * @param Array $data MerchantID MerchantTradeNo MerchantTradeDate PaymentType TotalAmount TradeDesc ItemName ReturnURL ClientBackURL ChoosePayment
	 */
	public function createOrder($data) {
		$data["MerchantID"] = $this->_merchantID;
		$data["MerchantTradeDate"] = date("Y/m/d H:i:s");
		$data["PaymentType"] = "aio";
		
		ksort($data);
		$query = "HashKey=".$this->_hashKey."&".urldecode(http_build_query($data))."&HashIV=".$this->_hashIV;
		$data["CheckMacValue"] = strtoupper(md5(strtolower(urlencode($query))));

		require_once("order.submit.php");
	}

	public function validateCheckMacValue($post_data) {
		if (!isset($post_data["CheckMacValue"])) {
			return false;
		}

		$checkmacvalue = $post_data["CheckMacValue"];
		unset($post_data["CheckMacValue"]);
		ksort($post_data);
		$query = "HashKey=".$this->_hashKey."&".urldecode(http_build_query($post_data))."&HashIV=".$this->_hashIV;
		
		return (strtoupper(md5(strtolower(urlencode($query)))) == $checkmacvalue);
	}
}
?>