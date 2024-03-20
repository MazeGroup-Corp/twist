<?php
include "connect.php";

session_start();
$sql = "SELECT blocked FROM users WHERE id = ". $_SESSION['id'] ."";
$resultat = $conn->query($sql);
if ($resultat->num_rows > 0) {
    $row = $resultat->fetch_assoc();
    if ($row['blocked'] == 0) {
        header("Location: ../home/");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Blocked - Twist</title>
        <?php require "style.php"; ?>
        <link rel="shortcut icon" href="/assets/icon_v1.png" type="image/x-icon">
    </head>
    <body>
        <div id="container">
            <div class="block navbar" style="width: 100%;">
                <div class="left flex">
                    <a href="../"><img src="../assets/logo_v1.png" alt="Twist Logo" class="logo"></a>
                </div>
            </div>
            <div style="text-align: center;">
                <h1>Account Bloked</h1>
                <h3>Your account is blocked !<br>
                For more information contact our on <a href="mailto:support@mazegroup.org">support@mazegroup.org</a></h3>
                <a href="logout.php">Logout</a>
            </div>
            <hr>
            <footer>
                <div class="centered">
                    <div class="jflex">
                        <img src="../assets/icon_v1.png" alt="Twist Icon" width="70">
                        <img src="../assets/logo_v1.png" alt="Twist Icon" width="110" height="40">
                    </div>
                    <div class="vhr">
                        <div style="margin-left: 20px; width: 100vw; user-select: none;">
                            <h3>Twist by MazeGroup</h3>
                            <h3>2023, started the 21/12</h3>
                            <p xmlns:cc="http://creativecommons.org/ns#" >This work is licensed under <a href="http://creativecommons.org/licenses/by-nd/4.0/?ref=chooser-v1" target="_blank" rel="license noopener noreferrer" style="display:inline-block;">CC BY-ND 4.0<img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/nd.svg?ref=chooser-v1"></a></p>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    </body>
</html>
