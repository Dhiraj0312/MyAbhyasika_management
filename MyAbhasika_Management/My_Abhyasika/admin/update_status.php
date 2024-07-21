<?php
// Include database connection code (config.php)
include('includes/config.php');

if (isset($_POST['update_status'])) {
    $studentId = $_POST['student_id'];

    // Check if the student exists in the registration table
    $checkQuery = "SELECT * FROM registration WHERE student_id = '$studentId'";
    $result = $mysqli->query($checkQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $subscriptionEndDate = $row['subscription_end_date'];
        $currentDate = date('Y-m-d');

        if ($subscriptionEndDate < $currentDate) {
            // Subscription has expired, update status to 'inactive'
            $updateQuery = "UPDATE registration SET status = 'inactive' WHERE student_id = '$studentId'";
            if ($mysqli->query($updateQuery)) {
                echo "Student status updated to 'inactive'.";
            } else {
                echo "Error updating student status: " . $mysqli->error;
            }
        } else {
            echo "Student subscription is still active.";
        }
    } else {
        echo "Student not found in the database.";
    }
}

// Close the database connection
$mysqli->close();
?>
