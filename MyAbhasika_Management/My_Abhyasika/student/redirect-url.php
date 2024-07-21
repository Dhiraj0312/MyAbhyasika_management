<?php
$response = $_POST; // Fetch data from the POST request
$saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399'; // KEY
$saltindex = 1; // KEY_INDEX

// Build the string for hashing
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

if ($final === null) {
    echo "Error decoding the response: " . json_last_error_msg();
} else {
    // Debug: output the decoded response for inspection
    var_dump($final);

    // Check if the transaction details indicate success
    if (isset($final['data']['state']) && isset($final['data']['responseCode']) &&
        $final['data']['state'] === 'COMPLETED' && $final['data']['responseCode'] === 'SUCCESS') {
        // Include your MySQLi connection code
        include('../includes/dbconn.php');

        // Access the transaction details
        $transactionId = $final['data']['transactionId'];
        $amount = $final['data']['amount'];
        $merchantId = $final['data']['merchantId'];
        $merchantTransactionId = $final['data']['merchantTransactionId'];
        $state = $final['data']['state'];
        $responseCode = $final['data']['responseCode'];

        // Access paymentInstrument details
        $paymentInstrument = $final['data']['paymentInstrument'];
        $paymentInstrumentType = $paymentInstrument['type'];
        $pgTransactionId = $paymentInstrument['pgTransactionId'];
        $pgServiceTransactionId = $paymentInstrument['pgServiceTransactionId'];
        $bankTransactionId = $paymentInstrument['bankTransactionId'];
        $bankId = $paymentInstrument['bankId'];

        // Prepare and execute the SQL query to insert the data
        $sql = "INSERT INTO transaction_details (transactionId, amount, merchantId, merchantTransactionId, state, responseCode, paymentInstrumentType, pgTransactionId, pgServiceTransactionId, bankTransactionId, bankId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }

        if ($stmt->bind_param('sississssss', $transactionId, $amount, $merchantId, $merchantTransactionId, $state, $responseCode, $paymentInstrumentType, $pgTransactionId, $pgServiceTransactionId, $bankTransactionId, $bankId)) {
            if ($stmt->execute()) {
                echo "Transaction details stored successfully.";
            } else {
                echo "Error storing transaction details: " . $stmt->error;
            }
        } else {
            echo "Bind failed: " . $stmt->error;
        }
    }
}
?>
