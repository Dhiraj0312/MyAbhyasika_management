<?php
// Include the checkSubscriptionStatus function
include('config.php'); // Include your database connection code
include('check_subscription_status.php');

// Usage example:
$userId = 123; // Replace with the actual user ID.
$subscriptionStatus = checkSubscriptionStatus($userId);

if ($subscriptionStatus === "paid") {
    echo "User is a paid subscriber with an active subscription.";
} else {
    echo "User is unpaid or has an expired subscription.";
}
