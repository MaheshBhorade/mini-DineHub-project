<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone= $_POST['phone'];
    $eventtype = $_POST['eventtype'];
    $datetime = $_POST['datetime'];
    $guests= $_POST['guests'];
    $foodpref = $_POST['foodpref'];
    $specialreq = $_POST['specialreq'];

    $conn = new mysqli('localhost','root','','register');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO record (name, phone_no, type, date_time, guest_count, food_pref, special_req, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("ssssssss", $fullname, $phone, $eventtype, $datetime, $guests, $foodpref, $specialreq, $email);
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }

    echo "Registration Successful...";
    
    $stmt->close();
    $conn->close();
}
?>
