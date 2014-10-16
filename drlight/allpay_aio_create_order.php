<?php
require_once("inc/Allpay.class.php");

$allpay = new Allpay(array("debug" => true));

$data = array(
	"MerchantTradeNo" => uniqid("DRLIGHT"),
	"TotalAmount" => "1000",
	"TradeDesc" => "小額捐款",
	"ItemName" => "小額捐款1000元",
	"ReturnURL" => "http://www.howme.tw/test/allpay_aio_receive.php",
	// "ClientBackURL" => "http://www.dcview.com/kff/done.php",
	"PaymentInfoURL" => "http://www.howme.tw/test/allpay_aio_paymentinfo.php",
	"ChoosePayment" => "CVS",
);

$allpay->createOrder($data);
?>