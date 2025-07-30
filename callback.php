<?php

include('db.php');

// Retrieve and decode JSON data from the callback
$callbackData = file_get_contents("php://input");
$data = json_decode($callbackData, true);

if (!empty($data['Body']['stkCallback'])) {
    $stkCallback = $data['Body']['stkCallback'];
    $resultCode = $stkCallback['ResultCode'];
    $checkoutRequestID = $stkCallback['CheckoutRequestID'];
    $status = $resultCode === 0 ? "Success" : "Failed";

    // If successful, retrieve additional payment details
    $receiptNumber = null;
    $amountPaid = null;
    $phoneNumber = null;

    if (isset($stkCallback['CallbackMetadata']['Item'])) {
        foreach ($stkCallback['CallbackMetadata']['Item'] as $item) {
            if ($item['Name'] === "MpesaReceiptNumber") {
                $receiptNumber = $item['Value'];
            }
            if ($item['Name'] === "Amount") {
                $amountPaid = $item['Value'];
            }
            if ($item['Name'] === "PhoneNumber") {
                $phoneNumber = $item['Value'];
            }
        }
    }

    // Update transaction record
    $stmt = $conn->prepare("
        UPDATE transactions 
        SET status = ?, receipt_number = ?, amount = ?, phone_number = ? 
        WHERE status = 'Pending' AND transaction_id = ?
    ");
    $stmt->bind_param("ssdss", $status, $receiptNumber, $amountPaid, $phoneNumber, $checkoutRequestID);
    $stmt->execute();
    $stmt->close();
}

// Close database connection
$conn->close();

?>
