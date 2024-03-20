<?php

session_start();

require "../connect.php" ;
if ($_SESSION['company_id'] == $_GET['id']) {
    if (isset($_POST['edit_account'])){
        if (!empty(htmlspecialchars($_POST['username']))){
            $er = false;
            $username_len = strlen(htmlspecialchars($_POST['username']));
            $username = htmlspecialchars($_POST['username']);
            $biography = htmlspecialchars(htmlspecialchars($_POST['biography']));
            $biography_len = strlen(htmlspecialchars($_POST['biography']));
            if ($username_len >= 3 && $username_len <= 16){} else {
                $er = true;
                header("Location: edit.php?account_edit_err=len_username?id=".$_SESSION['id']."");
            }

            $checkUsername = "SELECT * FROM users WHERE username='$username'";
            $checkResult = $conn->query($checkUsername);

            if ($er == false){
                if ($biography_len <= 200){} else {
                    $er = true;
                    header("Location: edit.php?account_edit_err=len_biography?id=".$_SESSION['company_id']."");
                }
                if ($er == false){
                    if (isset($_FILES['profile_pic']['tmp_name']) && !empty($_FILES['profile_pic']['tmp_name'])) {
                        $picture = addslashes(file_get_contents($_FILES['profile_pic']['tmp_name']));
                        $updateAvatarQuery = "UPDATE companies SET logo='$picture' WHERE id=" . $_SESSION['company_id'];
                        $stmt = $conn->query($updateAvatarQuery);
                        header("Location: edit.php?id=". $_SESSION['company_id']."");
                    } elseif (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] != UPLOAD_ERR_NO_FILE) {
                        $er = true;
                        header("Location: edit.php?account_edit_err=pic_err?id=".$_SESSION['company_id']."");
                    }

                    if ($er == false){
                        $updateQuery = "UPDATE companies SET name='$username' WHERE id=" . $_SESSION['company_id'];
                        $result = mysqli_query($conn, $updateQuery);
                        
                        $updateQuery = "UPDATE companies SET description='$biography' WHERE id=" . $_SESSION['company_id'];
                        $result = mysqli_query($conn, $updateQuery);

                        header("Location: edit.php?id=".$_SESSION['company_id']."");
                    }
                }
            }
        }
    }
}