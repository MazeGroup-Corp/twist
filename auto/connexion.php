<?php
session_start();

include '../connect.php'; 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Twist - Login</title>
        <?php require "../style.php"; ?>
        <link rel="shortcut icon" href="../assets/icon_v1.png" type="image/x-icon">
    </head>
    <body>
        <div id="container">
            <div class="block navbar" style="width: 100%;">
                <div class="left flex">
                    <a href="../"><img src="../assets/logo_v1.png" alt="Twist Logo" class="logo"></a>
                    <h3 class="title">Twist - Login</h3>
                </div>
            </div>
            <div class="page">
                <div class="twos">
                    <div>
                        <div class="twist-post-section" style="margin-left: auto; margin-right: auto; text-align: center; width: 20%;">
                            <h2>Log In witch...</h2><br>
                            <?php
                            $ip = $_SERVER['REMOTE_ADDR'];

                            $checkIP = "SELECT * FROM ip WHERE ip='$ip'";
                            $ipresult = $conn->query($checkIP);
                            
                            if(isset($_GET['change_account'])){
                                unset($_SESSION['connected']);
                            }
                            
                            if(!isset($_SESSION['connected'])){
                                if ($ipresult->num_rows > 0){
                                    while ($row = $ipresult->fetch_assoc()) {
                                        $account_id = $row['account_id'];
                                        
                                        // Recup Info Users
                                        
                                        $checkUser = "SELECT * FROM users WHERE id='$account_id'";
                                        $userresult = $conn->query($checkUser);
                                        $row = $userresult->fetch_assoc();
                                        
                                        $u_username = $row['username'];
                                        $u_picture = $row['picture'];
                                        $u_blocked = $row['blocked'];
                                        ?>
                                        <a href="../home/?id=<?php echo $account_id ?>" style="color: black; text-decoration: none;"><div>
                                            <div style="display: flex">
                                                <img class="pic" style="width: 50px; margin-right: 20px;" src="<?php 
                                                    if ($u_blocked == 1){
                                                        echo "../assets/accb.png";
                                                    }
                                                    else if (!empty($u_picture)) {
                                                        echo "data:image/jpeg;base64," . base64_encode($u_picture);
                                                    } else {
                                                        echo "../assets/default_pic.png";
                                                    }
                                                    ?>">
                                                <h1 style="text-transform: capitalize;"><?php echo $u_username; ?>
                                            </div>
                                        </div><br>
                                        </a>
                            <?php
                                    }
                                }
                            }
                            ?>
                            <button><a href="../welcome/?add_account=1" style="text-decoration: none; color: black;">Add account</a></button>
                            <button><a href="../home/?id=-1" style="text-decoration: none; color: black;">Use Twist without an account</a></button>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <? include "../components/footer.php" ?>
        </div>
        <script>
            var container = document.getElementById('container');
            container.style.height = Math.max(window.innerHeight, container.scrollHeight) + 'px';
        </script>
    </body>
</html>
