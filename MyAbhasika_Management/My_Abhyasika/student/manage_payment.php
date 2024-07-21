<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Page</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your custom CSS styles -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <form action="" id="transaction_form">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="account_name">Account Name</label>
                        <input type="text" name="account_name" id="account_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="text" name="account_number" id="account_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="amount_to_pay">Amount to Pay</label>
                        <input type="text" name="amount_to_pay" pattern="[0-9.]+" id="amount_to_pay" class="form-control text-right" required>
                    </div>
                </div>
            </div>
            <div class="card mt-3" id="pay-field" style="display:none;">
                <div class="card-body">
                    <h5 class="text-center text-info">Payment Summary</h5>
                    <hr>
                    <dl class="row">
                        <dt class="col-4 text-info">Amount to Pay</dt>
                        <dd class="col-8 text-right" id="pay_amount">0.00</dd>
                        <dt class="col-4 text-info">Service Fee</dt>
                        <dd class="col-8 text-right" id="fee">0.00</dd>
                    </dl>
                    <input type="hidden" name="fee" value="0">
                    <input type="hidden" name="payable_amount" value="0">
                    <input type="hidden" name="payment_code" value="">
                </div>
                <div class="card-footer text-center">
                    <div id="paypal-button"></div>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary" type="button" id="next">Next</button>
                <button class="btn btn-secondary" type="button" id="back" style="display:none;">Back</button>
                <button class="btn btn-light" type="button" id="cancel" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Add Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID&currency=PHP"></script>

    <!-- Add your JavaScript code here -->
    <script>
        // Paste your JavaScript code here
    </script>
</body>
</html>
