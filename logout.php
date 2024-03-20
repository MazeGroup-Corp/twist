<?php

session_start();
include "connect.php";

$id = $_SESSION['id'];
$ip = $_SERVER['REMOTE_ADDR'];

$result = $conn->prepare("DELETE FROM ip WHERE account_id = ? AND ip = ?"); 
$result->bind_param("ss", $id, $ip);
$result->execute();

header("Location: welcome/")

?>