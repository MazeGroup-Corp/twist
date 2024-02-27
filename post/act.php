<?php

session_start();

require "../connect.php" ;

if (isset($_POST['twist_post']) && isset($_SESSION['reply_to'])){
    if (!empty($_POST['text'])){
        $er = false;
        $text = htmlspecialchars($_POST['text']);
        $text_len = strlen(htmlspecialchars($_POST['text']));
        $id = $_SESSION['id'];
        $to_id = $_SESSION['reply_to'];
        if ($text_len >= 3 && $text_len <= 200){} else {
            $er = true;
            header("Location: .?post_inp_err=len_text");
        }
        if ($er == false){
            $sql = "INSERT INTO posts (user_id, text, datetime, reply_to) VALUES ('$id', '$text', NOW(), '$to_id')";
            $result = $conn->query($sql);
            header("Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
}