<?php
$response = $_POST; // FETCH DATA FROM DEFINE METHOD, IN THIS EXAMPLE, I AM DEFINING POST WHILE I AM SENDING REQUEST
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

// Insert the transaction details into your database
if ($final['data']['state'] === 'COMPLETED' && $final['data']['responseCode'] === 'SUCCESS') {
    // Database connection parameters
    include('../includes/dbconn.php'); // Include your MySQLi connection code

// Decode the JSON response into an array
$responseArray = json_decode($response, true);

// Access the transaction details
$transactionId = $responseArray['data']['transactionId'];
$amount = $responseArray['data']['amount'];

// Prepare and execute the SQL query to insert the data
$sql = "INSERT INTO transaction_details (transactionId, amount) VALUES (?, ?)"; // Use placeholders

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $mysqli->error);
}

if ($stmt->bind_param('si', $transactionId, $amount)) {
    if ($stmt->execute()) {
        echo "Transaction details stored successfully.";
    } else {
        echo "Error storing transaction details: " . $stmt->error;
    }
} else {
    echo "Bind failed: " . $stmt->error;
}

    // // Transaction details to insert
    // $transactionId = $response['transactionId'];
    // $amount = $response['amount'];

    // // Prepare and execute the SQL query to insert the data
    // $sql = "INSERT INTO your_table_name (transactionId, amount) VALUES (:transactionId, :amount)";
    // $stmt = $mysqli->prepare($sql);
    // $stmt->bindParam(':transactionId', $transactionId);
    // $stmt->bindParam(':amount', $amount);

    // if ($stmt->execute()) {
    //     echo "Transaction details stored successfully.";
    // } else {
    //     echo "Error storing transaction details: " . $stmt->errorInfo();
    // }
}
?>
