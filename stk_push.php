<?php
session_start();
include('db.php');

// Mpesa API credentials
$consumerKey = "OVTL45vYTROTsjpC6Wt8KcAme08jQ6PIiRRXeEXgmLoZe83a";
$consumerSecret = "76XPoZDgYVmmDbEzbMOwRsQuagz1I41RoQPMzRBlY5Mv4uG972ASDClImV8m7w6W";
$businessShortCode = "174379";
$passKey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$callbackURL = "https://yourdomain.com/callback.php"; // Replace with actual callback URL

// Ensure POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "⚠️ Please submit the form from the checkout page.";
    exit;
}

// Get inputs
$phoneRaw     = $_POST['phone'] ?? null;
$amount       = $_POST['amount'] ?? null;
$address      = $_POST['specific_address'] ?? null;
$product_name = $_POST['product_name'] ?? null;
$email        = $_POST['email'] ?? null;

if (!$phoneRaw || !$amount || !$address || !$product_name || !$email) {
    die("⚠️ Missing required form data.");
}

// Format phone
$phone = preg_replace('/\s+/', '', $phoneRaw);
if (substr($phone, 0, 1) === "0") {
    $phone = "254" . substr($phone, 1);
}
if (!preg_match('/^2547\d{8}$/', $phone)) {
    die("❌ Invalid Phone Number Format.");
}

$quantity = 1;
$status = "Pending";

// Generate access token
$credentials = base64_encode("$consumerKey:$consumerSecret");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$token_response_raw = curl_exec($ch);
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    exit;
}
curl_close($ch);

$token_response = json_decode($token_response_raw);
if (!isset($token_response->access_token)) {
    echo "Token Response Error:<br><pre>$token_response_raw</pre>";
    die("❌ Error getting access token.");
}
$accessToken = $token_response->access_token;

// Initiate STK Push
$timestamp = date("YmdHis");
$password = base64_encode($businessShortCode . $passKey . $timestamp);

$stkPayload = [
    "BusinessShortCode" => $businessShortCode,
    "Password" => $password,
    "Timestamp" => $timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $amount,
    "PartyA" => $phone,
    "PartyB" => $businessShortCode,
    "PhoneNumber" => $phone,
    "CallBackURL" => $callbackURL,
    "AccountReference" => "Wandering Bean Cafe",
    "TransactionDesc" => "Payment for coffee"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($stkPayload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch), true);
curl_close($ch);

// Log STK response
file_put_contents("stk_response_log.txt", json_encode($response, JSON_PRETTY_PRINT));

// If STK request was successful
if (isset($response['ResponseCode']) && $response['ResponseCode'] === "0") {
    $transactionID = uniqid('txn_');

    // ✅ Reduce stock from session cart
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $stmt = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE name = ?");
            $stmt->bind_param("is", $item['quantity'], $item['name']);
            $stmt->execute();
        }
        unset($_SESSION['cart']); // Clear cart
    }

    // ✅ Assign delivery person
    $deliveryPersonId = null;
    $deliveryResult = $conn->query("SELECT id FROM delivery_persons WHERE status = 'Available' LIMIT 1");
    if ($deliveryResult && $deliveryResult->num_rows > 0) {
        $row = $deliveryResult->fetch_assoc();
        $deliveryPersonId = $row['id'];
        $conn->query("UPDATE delivery_persons SET status = 'Assigned' WHERE id = $deliveryPersonId");
    }

    // ✅ Save transaction
    $stmt = $conn->prepare("
        INSERT INTO transactions (transaction_id, product_name, quantity, amount, phone_number, email, address, status, delivery_person_id, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("ssidssssi", $transactionID, $product_name, $quantity, $amount, $phone, $email, $address, $status, $deliveryPersonId);
    $stmt->execute();
    $stmt->close();

    // ✅ Send confirmation email via Web3Forms
    $web3forms_url = "https://api.web3forms.com/submit";
    $web3forms_api_key = "9385f35d-1dc4-4142-8479-48d4fb83fc59";

    $email_data = [
        "access_key" => $web3forms_api_key,
        "from_name"  => "Wandering Bean Coffee Shop",
        "subject"    => "Your Order Confirmation – Wandering Bean",
        "email"      => $email,
        "message"    => "Hi there! Thank you for your order of '{$product_name}' totaling Kshs. {$amount}. Your order will be delivered to: {$address}. We appreciate your support!"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $web3forms_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($email_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $email_response = curl_exec($ch);
    curl_close($ch);

    // Log email response
    file_put_contents("web3forms_response_log.txt", $email_response . "\n", FILE_APPEND);

    // ✅ Redirect
    header("Location: confirmation.php?status=Pending&transaction_id=$transactionID");
    exit;
} else {
    echo "❌ Error: Payment initiation failed.<br>";
    echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT) . "</pre>";
}
?>
