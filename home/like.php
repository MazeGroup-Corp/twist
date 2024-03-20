<?php

session_start();

require "../connect.php";

if(isset($_SESSION["connected"])){
    if($_SESSION["connected"] == TRUE){
        if (isset($_GET["to_post_id"])) {
            $to_post_id = $_GET["to_post_id"];
        
            $checkQuery = "SELECT * FROM likes WHERE from_id = ? AND to_post_id = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("ii", $_SESSION["id"], $to_post_id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
        
            if ($checkResult->num_rows > 0) {
                $deleteQuery = "DELETE FROM likes WHERE from_id = ? AND to_post_id = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("ii", $_SESSION["id"], $to_post_id);
                $deleteStmt->execute();
                $deleteStmt->close();
                header("Location:" . $_SERVER['HTTP_REFERER']);
            } else {
                $insertQuery = "INSERT INTO likes (from_id, to_post_id, datetime) VALUES (?, ?, NOW())";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("ii", $_SESSION["id"], $to_post_id);
                $insertStmt->execute();
                $insertStmt->close();
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        
            $checkStmt->close();
        }
    } else {
        header("Location:" . $_SERVER['HTTP_REFERER']);
    }
} else {
    header("Location:" . $_SERVER['HTTP_REFERER']);
}

?>
