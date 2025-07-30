<?php
include('db.php');
include('stk_push.php');

// Select delivery persons assigned more than 45 minutes ago
$query = "
    UPDATE delivery_persons 
    SET status = 'Available', assigned_at = NULL 
    WHERE status = 'Assigned' 
      AND assigned_at IS NOT NULL 
      AND assigned_at <= NOW() - INTERVAL 45 MINUTE
";

if ($conn->query($query) === TRUE) {
    echo "✅ Delivery statuses reset successfully.";
} else {
    echo "❌ Error resetting delivery statuses: " . $conn->error;
}
?>
