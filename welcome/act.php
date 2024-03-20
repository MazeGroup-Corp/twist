<?php

session_start();

require "../connect.php" ;

// Signup

if (isset($_POST['signup'])){
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password_confirmation'])){
        $username = htmlspecialchars($_POST['username']);
        $username_l = strtolower($username);
        $username_len = strlen($username_l);
        $ip = $_SERVER['REMOTE_ADDR'];
        $er = false;
        if ($username_len >= 3 && $username_len <= 16){} else {
            $er = true;
            header("Location: .?1_err=len_username");
        }
        if ($er == false){
            $email = strtolower(htmlspecialchars($_POST['email']));
            if ($_POST['password'] !== $_POST['password_confirmation']){
                header("Location: .?1_err=same_password");
            } else {
                $password_len = strlen($_POST['password']);
                $password = sha1($_POST['password']);
                $password_conf = sha1($_POST['password_confirmation']);
                if ($password_len >= 3 && $password_len <= 16){} else {
                    $er = true;
                    header("Location: .?1_err=len_password");
                }
                $check_email = "SELECT * FROM users WHERE email='$email'";
                $check_email_r = $conn->query($check_email);
                if($check_email_r->num_rows > 0 && $email !== ""){
                    $er = true;
                    header("Location: .?1_err=email_already");
                }
                if ($er == false){
                    $checkUsername = "SELECT * FROM users WHERE username='$username_l'";
                    $checkResult = $conn->query($checkUsername);

                    if($checkResult->num_rows > 0){
                        header("Location: .?1_err=username_already");
                    } else {
                        $bio = "";
                        $sql = "INSERT INTO users (username, email, password, biography, ip, creation_date) VALUES ('$username_l', '$email', '$password', '$bio', '$ip' ,NOW())";
                        $result = $conn->query($sql);

                        $checkUsername = "SELECT * FROM users WHERE username='$username_l' AND password='$password'";
                        $checkResult = $conn->query($checkUsername);
                        $row = $checkResult->fetch_assoc();
            
                        if($result){
                            $_SESSION['connected'] = true;
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['password'] = $row['password'];
                            $_SESSION['biography'] = $row['biography'];
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['admin'] = $row['admin'];
                            $_SESSION['creation_date'] = $row['creation_date'];
                            $account_id = $row['id'];
                            $ip = $_SERVER['REMOTE_ADDR'];
                            $sql = "INSERT INTO ip (ip, account_id) VALUES ('$ip', '$account_id')";
                            $result = $conn->query($sql);
                            header("Location: ../home/");
                            header("Location: ../welcome/");
                        }else{
                            header("Location: .?1_err=_");
                        }
                    }
                }
            }
        }
    } else {
        echo "Form error";
    }

// Login
} elseif (isset($_POST['login'])){
    if (!empty($_POST['username']) && !empty($_POST['password'])){
        $username = strtolower(htmlspecialchars($_POST['username']));
        $er = false;
        $password = sha1($_POST['password']);
        $checkUsername = "SELECT * FROM users WHERE username='$username'";
        
        $checkResult = $conn->query($checkUsername);
        $row = $checkResult->fetch_assoc();

        if($checkResult->num_rows > 0){
            if($checkResult->num_rows !== 1){
                $er = true;
                header("Location: .?2_err=_");
            } else {
                if ($row['password'] == $password){
                    $_SESSION['connected'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['biography'] = $row['biography'];
                    $_SESSION['admin'] = $row['admin'];
                    $_SESSION['country'] = $row['country'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['creation_date'] = $row['creation_date'];
                    $_SESSION['company_id'] = $row['company_id'];
                    
                    // AUTO CONNEXION
                    
                    $account_id = $row['id'];
                    $ip = $_SERVER['REMOTE_ADDR'];
                    
                    $sql = "SELECT * FROM ip WHERE ip='$ip' AND account_id=$account_id";
                    $result = $conn->query($sql);
                    
                    if($result->num_rows > 0){
                        header("Location: ../home/");
                    }else{
                        $sql = "INSERT INTO ip (ip, account_id) VALUES ('$ip', '$account_id')";
                        $result = $conn->query($sql);
                        header("Location: ../home/");
                    }
                } else {
                    header("Location: .?2_err=bad_password");
                }
            }
        } else {
            header("Location: .?2_err=bad_username");
        }
    } else {
        echo "Form error";
    }
} else {
    echo "Form error";
}

?>