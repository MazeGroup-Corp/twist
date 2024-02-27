<?php

session_start();

require "../connect.php" ;

if (isset($_GET["post_id"])) {
    $post_id = $_GET["post_id"];

    if ($post_id == $_SESSION["id"] || $_SESSION['admin'] == 1) {
        $deleteQuery = "DELETE FROM posts WHERE id = ". $post_id ."";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->execute();
        $deleteStmt->close();
        header("Location: ../home/");
    } else {
        header("Location: ../home/");
    }
}