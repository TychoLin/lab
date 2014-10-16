<?php
// Barcode1
// Barcode2
// Barcode3
// ExpireDate
// MerchantID
// MerchantTradeNo
// PaymentNo
// PaymentType
// RtnCode
// RtnMsg
// TradeAmt
// TradeDate
// TradeNo
// CheckMacValue

// BankCode
// ExpireDate
// MerchantID
// MerchantTradeNo
// PaymentType
// RtnCode
// RtnMsg
// TradeAmt
// TradeDate
// TradeNo
// vAccount
// CheckMacValue

file_put_contents("paymentinfo.record", json_encode($_POST));
echo "1|OK";
?>