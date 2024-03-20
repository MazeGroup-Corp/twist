<?php

session_start();

require "../connect.php" ;
if ($_SESSION['admin'] == 1) {
    $updateQuery = "UPDATE users SET blocked=0 WHERE id=". $_GET['id'];
    $result = mysqli_query($conn, $updateQuery);
    header("Location: index.php?id=". $_GET['id']);
}