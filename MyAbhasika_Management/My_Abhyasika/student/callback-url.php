<?php
$response = $_POST; // FETCH DATA FROM THE REQUEST (POST data)
$saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399'; // KEY
$saltindex = 1; // KEY_INDEX
$string = "/pg/v1/status/" . $response['merchantId'] . "/" . $response['transactionId'] . $saltKey;
$sha256 = hash("sha256", $string);
$final_x_header = $sha256 . '###' . $saltindex;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/" . $response['merchantId'] . "/" . $response['transactionId']);

curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "accept: application/json",
    "X-VERIFY: " . $final_x_header,
    "X-MERCHANT-ID:" . $response['merchantId']
));

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

$final = json_decode($response, true);

// Process the $final data as needed, e.g., log it or send a response back to PhonePe

// Send a response back to PhonePe if required
if ($final) {
    // Process $final data
    // For example, log it or update your database
    // ...

    // Send a response back to PhonePe
    // You can choose the response format, e.g., JSON or XML
    $response_data = array(
        'status' => 'success',
        'message' => 'Transaction status updated successfully',
    );

    header('Content-Type: application/json');
    echo json_encode($response_data);
} else {
    // Handle errors or invalid response from PhonePe
    // You can log the error and send an appropriate response
    $error_data = array(
        'status' => 'error',
        'message' => 'Failed to update transaction status',
    );

    header('Content-Type: application/json');
    echo json_encode($error_data);
}

// Close the cURL connection
curl_close($curl);
?>
