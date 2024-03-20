<?php

session_start();

require "../connect.php" ;
if ($_SESSION['id'] == $_GET['id']) {
    if (isset($_POST['edit_account'])){
        if (!empty(htmlspecialchars($_POST['username']))){
            $er = false;
            $username_len = strlen(htmlspecialchars($_POST['username']));
            $username = htmlspecialchars($_POST['username']);
            if ($_SESSION['admin'] == 1){
                $biography = $_POST['biography'];
                $biography_len = strlen($_POST['biography']);
            }else{
            $biography = htmlspecialchars($_POST['biography']);
            $biography_len = strlen(htmlspecialchars($_POST['biography']));
            }
            if ($username_len >= 3 && $username_len <= 16){} else {
                $er = true;
                header("Location: .?account_edit_err=len_username?id=".$_SESSION['id']."");
            }

            $checkUsername = "SELECT * FROM users WHERE username='$username'";
            $checkResult = $conn->query($checkUsername);

            if($checkResult->num_rows > 0 && ($username !== $_SESSION['username'])){
                $er = true;
                header("Location: .?account_edit_err=username_already?id=".$_SESSION['id']."");
            }

            if ($er == false){
                if ($biography_len <= 200){} else {
                    $er = true;
                    header("Location: .?account_edit_err=len_biography?id=".$_SESSION['id']."");
                }
                if ($er == false){
                    if (isset($_FILES['profile_pic']['tmp_name']) && !empty($_FILES['profile_pic']['tmp_name'])) {
                        $picture = addslashes(file_get_contents($_FILES['profile_pic']['tmp_name']));
                        $updateAvatarQuery = "UPDATE users SET picture='$picture' WHERE id=" . $_SESSION['id'];
                        $stmt = $conn->query($updateAvatarQuery);
                        header("Location: .");
                    } elseif (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] != UPLOAD_ERR_NO_FILE) {
                        $er = true;
                        header("Location: .?account_edit_err=pic_err?id=".$_SESSION['id']."");
                    }

                    if ($er == false){
                        $country = $_POST['country'];
                        $updateQuery = "UPDATE users SET username='$username' WHERE id=" . $_SESSION['id'];
                        $result = mysqli_query($conn, $updateQuery);
                        
                        $updateQuery = "UPDATE users SET biography='$biography' WHERE id=" . $_SESSION['id'];
                        $result = mysqli_query($conn, $updateQuery);
                        
                        $updateQuery = "UPDATE users SET country='$country' WHERE id=" . $_SESSION['id'];
                        $result = mysqli_query($conn, $updateQuery);

                        $_SESSION['username'] = $username;
                        $_SESSION['biography'] = $biography;
                        $_SESSION['country'] = $country;
                        header("Location: .?id=".$_SESSION['id']."");
                    }
                }
            }
        }
    }
}