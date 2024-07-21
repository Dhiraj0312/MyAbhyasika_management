<?php
$response = $_POST; // FETCH DATA FROM DEFINE METHOD, IN THIS EXAMPLE I AM DEFINING POST WHILE I AM SENDING REQUEST
$saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399'; // KEY
$saltindex = 1; // KEY_INDEX
$string = "/pg/v1/status/" . $response['merchantId'] . "/" . $response['transactionId'] . $saltKey;
$sha256 = hash("sha256", $string);
$final_x_header = $sha256 . '###' . $saltindex;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/" . $response['merchantId'] . "/" . $response['transactionId']);

curl_setopt($curl, CURLOPT_HTTPHEADER,
    array(
        "Content-Type: application/json",
        "accept: application/json",
        "X-VERIFY: " . $final_x_header,
        "X-MERCHANT-ID:" . $response['merchantId']
    )
);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

$final = json_decode($response, true);

// Check if the response data is not empty and contains the expected fields
if (!empty($final) && isset($final['data']['merchantId'])) {
    // Continue with database insertion (next part)
} else {
    echo "Failed to retrieve valid transaction data from PhonePe.";
}

// Close the cURL connection
curl_close($curl);
?>



<?php



session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');

check_login();



if (!empty($final) && isset($final['data']['merchantId'])) {
    // Include your database connection code here (e.g., include('../includes/dbconn.php');)
    
    // Extract relevant data from the response
    $merchantId = $final['data']['merchantId'];
    $merchantTransactionId = $final['data']['merchantTransactionId'];
    $transactionId = $final['data']['transactionId'];
    $amount = $final['data']['amount'];
    $state = $final['data']['state'];
    $responseCode = $final['data']['responseCode'];
    
    // Prepare an SQL INSERT statement
    $insertQuery = "INSERT INTO payment_transactions (merchantId, merchantTransactionId, transactionId, amount, state, responseCode) VALUES (?, ?, ?, ?, ?, ?)";
   
    // Create a prepared statement
    $stmt = $mysqli->prepare($insertQuery); // Replace $your_pdo_instance with your actual PDO instance
    
    // Bind parameters and execute the statement
    $stmt->execute([$merchantId, $merchantTransactionId, transactionId, $amount, $state, $responseCode]);
    
    echo "Transaction data inserted into the database successfully.";
} else {
    echo "Failed to retrieve valid transaction data from PhonePe.";
}
header('location:' . $final['data']['instrumentResponse']['redirectInfo']['url']);
?>
