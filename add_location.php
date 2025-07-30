<?php

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $area_name = $_POST['area_name'];

    $query = "INSERT INTO delivery_areas (area_name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $area_name);

    if ($stmt->execute()) {
        header("Location: locations.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
