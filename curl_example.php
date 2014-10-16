<?php
// $post_url = "www.dcview.com/kff/app/app_api_sn.php";
// $post_url = "www.dcview.com/kff/app/app_api_movie.php";
// $post_url = "www.dcview.com/kff/app/app_api_vc.php";
$post_url = "www.dcview.com/kff/app/app_api_oplog.php";
// $post_url = "192.168.2.54:9999/kff-web/app/app_api_sn.php";
// $post_url = "192.168.2.54:9999/kff-web/app/app_api_vc.php";
// $post_url = "192.168.2.54:9999/kff-web/app/app_api_login.php";
// $post_url = "192.168.2.54:9999/kff-web/app/app_api_oplog.php";
$post_url = "192.168.2.54:44630/drlight/admin/trumbowyg.upload.php";

$op_status = (mt_rand() % 2 == 1) ? "P" : "B";

$data = array(
	"apikey" => "9dcba708e91abe2f1ef6b087a2c57fac",
	"method_name" => "create",
	// "no-sn" => 0.25,
	// "free" => 0.25,
	// "paid" => 0.25,
	// "power" => 0.25,
	"account" => "dummy",
	"op_status" => $op_status,
	"device_id" => uniqid(),
	"device_city" => "Taipei",
	"sn_type" => mt_rand(1, 5),
	// "password" => "123qwe",
	// "ios_uuid" => "74419C43-13C4-43F2-B9DC-B7178F6986CA",
);

// $post_url .= "?".http_build_query($data);

// $post_url = "www.dcview.com/kff/allpay_aio_create_order.php";
// $data = array(
// 	"account" => "tycho.lin@gmail.com",
// 	"payment_type" => "Credit",
// );

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $post_url);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);

if (curl_errno($ch)) {
	echo 'Curl error: ' . curl_error($ch);
} else {
	var_dump(json_decode($output, true));
	// echo $output;
}

curl_close($ch);
?>