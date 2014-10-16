<?php
// MerchantID
// MerchantTradeNo
// RtnCode
// RtnMsg
// TradeNo
// TradeAmt
// PaymentDate
// PaymentType
// PaymentTypeChargeFee
// TradeDate
// SimulatePaid
// CheckMacValue
file_put_contents("receive.record", $_POST);
echo "1|OK";
?>