<?php

session_start();

require "../connect.php" ;

if (isset($_POST['insight_post'])){
    if (!empty($_POST['text'])){
        $er = false;
        $text = htmlspecialchars($_POST['text']);
        $text_len = strlen($_POST['text']);
        $username = $_SESSION['username'];
        $id = $_SESSION['id'];
        if ($text_len >= 3 && $text_len <= 160){} else {
            $er = true;
            header("Location: .?ins_inp_err=len_text");
        }
        if ($er == false){
            $sql = "INSERT INTO insights (user_id, message) VALUES ('$id', '$text')";
            $result = $conn->query($sql);
            header("Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
} elseif (isset($_POST['twist_post'])){
    if (!empty($_POST['text'])){
        $er = false;
        $text = htmlspecialchars($_POST['text']);
        $text_len = strlen($_POST['text']);
        $id = $_SESSION['id'];
        if ($text_len >= 3 && $text_len <= 400){} else {
            $er = true;
            header("Location: .?post_inp_err=len_text");
        }
        if ($er == false){
            $sql = "INSERT INTO posts (user_id, text, datetime) VALUES ('$id', '$text', NOW())";
            $result = $conn->query($sql);
            header("Location: index.php");
        }
    }
} elseif (isset($_POST['twist_post_cy'])){
    if (!empty($_POST['text'])){
        $er = false;
        $text = htmlspecialchars($_POST['text']);
        $text_len = strlen($_POST['text']);
        $id = $_SESSION['id'];
        $company_id = $_SESSION['company_id'];
        if ($text_len >= 3 && $text_len <= 400){} else {
            $er = true;
            header("Location: .?post_inp_err=len_text");
        }
        if ($er == false){
            $sql = "INSERT INTO posts (user_id, enterprise_id, text, datetime) VALUES ('$id', '$company_id' ,'$text', NOW())";
            $result = $conn->query($sql);
            header("Location: companies_posts.php");
        }
    }
}
?>

<?php
$sql = "SELECT blocked FROM users WHERE id = ". $_SESSION['id'] ."";
$resultat = $conn->query($sql);
if ($resultat->num_rows > 0) {
    $row = $resultat->fetch_assoc();
    if ($row['blocked'] == 1) {
        header("Location: ../blocked.php");
        exit();
    }
}
?>