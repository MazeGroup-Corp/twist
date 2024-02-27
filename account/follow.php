<?php

session_start();

require "../connect.php";

if (isset($_GET["to_id"])) {
    $to_id = $_GET["to_id"];

    $checkQuery = "SELECT * FROM follows WHERE from_id = ? AND to_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ii", $_SESSION["id"], $to_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $deleteQuery = "DELETE FROM follows WHERE from_id = ? AND to_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("ii", $_SESSION["id"], $to_id);
        $deleteStmt->execute();
        $deleteStmt->close();
        header("Location:" . $_SERVER['HTTP_REFERER']);
    } else {
        $insertQuery = "INSERT INTO follows (from_id, to_id, datetime) VALUES (?, ?, NOW())";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $_SESSION["id"], $to_id);
        $insertStmt->execute();
        $insertStmt->close();
        header("Location:" . $_SERVER['HTTP_REFERER']);
    }

    $checkStmt->close();
}

?>
