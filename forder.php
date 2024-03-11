<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name= $_POST['name'];
    $email = $_POST['email'];
    $phone= $_POST['phone'];
    $address = $_POST['address'];
    $time = $_POST['time'];
    $comment= $_POST['comments'];
    $instructions = $_POST['instructions'];

    $conn = new mysqli('localhost','root','','register');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO forder (name, email, phone, address ,date_time,comments,instructions) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("sssssss", $name,  $email , $phone,$address , $time, $comment , $instructions);
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }

    echo "Registration Successful...";
    
    $stmt->close();
    $conn->close();
}
?>
