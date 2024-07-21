<?php

$data = [
    
        "merchantId"=> "PGTESTPAYUAT",
        "merchantTransactionId"=> "MT7850590068188104",
        "merchantUserId"=> "MU933037302229373",
        "amount"=> 10000,
        "redirectUrl" => "http://localhost:80/Omkar/Omkar/student/redirect-url.php",

        "redirectMode" =>  "POST",
        "callbackUrl"=> "http://localhost/Omkar/Omkar/student/callback-url.php",
        "mobileNumber"=> "9999999999",
       
        "paymentInstrument" => [
            "type" => "PAY_PAGE"
        ]
    ];
  
$saltKey = "099eb0cd-02cf-4e2a-8aca-3e6c6aff0399";
$saltindex = 1;
$encode = json_encode($data);
$encoded = base64_encode($encode);


$string = $encoded . "/pg/v1/pay".$saltKey;
$sha256 = hash("sha256", $string);
$final_x_header = $sha256 . '###'.$saltindex;


// $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay");


curl_setopt($curl, CURLOPT_HTTPHEADER, 
array(
    "Content-Type: application/json",
    "accept: application/json",
    "X-VERIFY: " . $final_x_header,
)
);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("request"=>$encoded)));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);


$final = json_decode($response,true);

// echo  "<pre>";
// print_r($final);
// echo  "<pre>";
header('location:' . $final['data']['instrumentResponse']['redirectInfo']['url']);

?>