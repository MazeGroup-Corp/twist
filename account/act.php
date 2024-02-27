<?php

session_start();

require "../connect.php" ;

if (isset($_POST['edit_account'])){
    if (!empty($_POST['username'])){
        $er = false;
        $username_len = strlen($_POST['username']);
        $username = $_POST['username'];
        $biography = $_POST['biography'];
        $biography_len = strlen($_POST['biography']);
        if ($username_len >= 3 && $username_len <= 16){} else {
            $er = true;
            header("Location: .?account_edit_err=len_username");
        }

        $checkUsername = "SELECT * FROM users WHERE username='$username'";
        $checkResult = $conn->query($checkUsername);

        if($checkResult->num_rows > 0 && ($username !== $_SESSION['username'])){
            $er = true;
            header("Location: .?account_edit_err=username_already");
        }

        if ($er == false){
            if ($biography_len <= 200){} else {
                $er = true;
                header("Location: .?account_edit_err=len_biography");
            }
            if ($er == false){
                if (isset($_FILES['profile_pic']['tmp_name']) && !empty($_FILES['profile_pic']['tmp_name'])) {
                    $picture = addslashes(file_get_contents($_FILES['profile_pic']['tmp_name']));
                    $updateAvatarQuery = "UPDATE users SET picture='$picture' WHERE id=" . $_SESSION['id'];
                    $stmt = $conn->query($updateAvatarQuery);
                    header("Location: .");
                } elseif (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] != UPLOAD_ERR_NO_FILE) {
                    $er = true;
                    header("Location: .?account_edit_err=pic_err");
                }

                if ($er == false){
                    $updateQuery = "UPDATE users SET username='$username' WHERE id=" . $_SESSION['id'];
                    $result = mysqli_query($conn, $updateQuery);
                    
                    $updateQuery = "UPDATE users SET biography='$biography' WHERE id=" . $_SESSION['id'];
                    $result = mysqli_query($conn, $updateQuery);

                    $_SESSION['username'] = $username;
                    $_SESSION['biography'] = $biography;
                    header("Location:" . $_SERVER['HTTP_REFERER']);
                }
            }
        }
    }
}