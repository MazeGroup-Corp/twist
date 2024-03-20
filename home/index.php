<?php

session_start();
error_reporting(0);

?>

<?php 

require '../connect.php';


if(isset($_SESSION["connected"])){
    if($_SESSION["connected"] == TRUE){
        $sql = "SELECT blocked FROM users WHERE id = ". $_SESSION['id'] ."";
        $resultat = $conn->query($sql);
        if ($resultat->num_rows > 0) {
            $row = $resultat->fetch_assoc();
            if ($row['blocked'] == 1) {
                header("Location: ../blocked.php");
                exit();
            }
        }
    }
}

$ip = $_SERVER['REMOTE_ADDR'];

$checkIP = "SELECT * FROM ip WHERE ip='$ip'";
$ipresult = $conn->query($checkIP);

if($_GET['id']){
    if($_GET['id'] == "-1"){
        $_SESSION['no_account'] == TRUE;
    }
}

if(!isset($_SESSION['no_account'])){
    if(!isset($_GET['id'])){
        if(!isset($_SESSION['connected'])){
            if ($ipresult->num_rows > 0){
                $row = $ipresult->fetch_assoc();
                header("Location: ../auto/connexion.php");
            }
        }
    } else {
        $recup_id = $_GET['id'];
        $usersql = "SELECT * FROM users WHERE id='$recup_id'";
        $checkResult = $conn->query($usersql);
        $row = $checkResult->fetch_assoc();
        if($checkResult->num_rows > 0){
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
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twist - Home</title>
    <?php require "../style.php"; ?>
    <link rel="shortcut icon" href="../assets/icon_v1.png" type="image/x-icon">
</head>

<body>

    <!-- Nabar -->

    <div id="container">
        <?php include '../components/navbar.php' ?>
        <div class="updates-bar">
            <marquee direction="left" scrollamount="3">Twist updates & news (now to old)
                <?php
                $sql = "SELECT title, description FROM updates ORDER BY id DESC";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo " • <bold>" . $row["title"] . "</bold> : ";
                        echo $row["description"];
                    }
                }
                ?>
            </marquee>
        </div>

        <!-- Affichage bar -->

        <div class="insights-bar">
            <marquee direction="left" scrollamount="4">Active insights

                <?php
                $sql = "SELECT user_id, message FROM insights ORDER BY id DESC LIMIT 6";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["user_id"];
                        $query = "SELECT username FROM users WHERE id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $stmt->bind_result($username);
                        $stmt->fetch();
                        $stmt->close();
                        $username = htmlspecialchars($username);
                        echo " • <bold style='text-transform: capitalize;'><a style='color: black;' href='../account?id=" . $id . "'>" . $username . "</a></bold> : ";
                        echo $row["message"];
                    }
                }
                ?>
            </marquee>
        </div>

        <!-- Principale page -->

        <div class="page">
            <h1 style="text-transform: capitalize;">
                <?php if(isset($_SESSION["connected"])){ echo $ts_hello; } ?>
            </h1>
            <hr>
            <div class="sections">
                <?php
                if (isset($_SESSION['connected'])) {
                if ($_SESSION['connected'] == true) {
                ?>
                <div class="part2 _">
                    <div class="insight-post-section">
                        <h2><?php echo $ts_post_insight ?> :</h2>

                        <form method="POST" action="/home/act.php">
                            <label for="text">Insight text :</label><br>
                            <input type="text" id="text" required name="text" minlength="3" maxlength="160"
                                placeholder="Lenght : 3 to 160" class="glass"><br>
                            <button type="sumbit" name="insight_post" class="glass"><?php echo $ts_post ?></button>
                            <?php
                            if (isset($_GET['ins_inp_err'])) {
                                $err = htmlspecialchars($_GET['ins_inp_err']);

                                switch ($err) {
                                    case 'len_text':
                                        ?>
                                        <red>
                                            The text lenght must be between 3 and 160 characters
                                        </red>
                                        <?php
                                        break;
                                }
                            }
                            ?>
                        </form>
                    </div>
                    <br>
                    <div class="twist-post-section">
                        <h2><?php echo $ts_post_twist ?> :</h2>

                        <form method="POST" action="/home/act.php">
                            <label for="text">Post text :</label><br>
                            <textarea cols="24" rows="4" id="text" required name="text" minlength="3" maxlength="400"
                                placeholder="Lenght : 3 to 400" class="glass"></textarea><br>
                            <button type="sumbit" name="twist_post" class="glass"><?php echo $ts_post ?></button>
                            <?php
                            if ($_SESSION['company_id'] != 0) {
                                ?>
                                <button type="sumbit" name="twist_post_cy" class="glass"><?php echo $ts_post_as_company ?></button>
                                <?php
                            }
                            if (isset($_GET['post_inp_err'])) {
                                $err = htmlspecialchars($_GET['post_inp_err']);

                                switch ($err) {
                                    case 'len_text':
                                        ?>
                                        <red>
                                            The text lenght must be between 3 and 400 characters
                                        </red>
                                        <?php
                                        break;
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
                <?php }}else{
                    ?>
                <div class="part2 _">
                    <div class="twist-post-section">
                        <h2>Enjoy Twist to the fullest!</h2>
                        <p>
                            Use the most functionality that Twist offers:<br>
                            - To see post Twists and replies <br>
                            - Personalized your profile (username, biography, logo) <br>
                            - Share things with the community! <br>
                            Twist is updated regularly, updates appear every week, hoping that you will like them, <br>
                            that's why we advise you to create an account and start being one of the real ones in the Twist community
                        </p>
                        <br>
                        <a href='../welcome/'><button style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>Register / Login</button></a>
                    </div>
                </div>
                <?php
                $_SESSION['username'] = "Invited";
                $_SESSION['company_id'] = "0";
                }
                ?>
                <div class="part1">
                    <h2><?php echo $ts_recommanded_accounts ?> :</h2>
                    <div class="accounts_list">
                            <?php

                            $sql = "SELECT u.id, u.username, u.picture, u.badge_official, u.badge_certif, u.badge_vip, COUNT(f.to_id) AS follow_count
                                FROM users u
                                LEFT JOIN follows f ON u.id = f.to_id
                                GROUP BY u.id
                                ORDER BY u.badge_official DESC, u.badge_certif DESC, u.badge_vip DESC, follow_count DESC
                                LIMIT 20";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $user__id = $row["id"];
                                    $username = $row["username"];
                                    $picture = $row["picture"];
                                    $badge_certif = $row["badge_certif"];
                                    $badge_vip = $row["badge_vip"];
                                    $badge_official = $row["badge_official"];

                                    $checkQuery = "SELECT * FROM follows WHERE from_id = ? AND to_id = ?";
                                    $checkStmt = $conn->prepare($checkQuery);
                                    $checkStmt->bind_param("ii", $_SESSION["id"], $user__id);
                                    $checkStmt->execute();
                                    $checkResult = $checkStmt->get_result();
                                    $countQuery = "SELECT COUNT(*) FROM follows WHERE to_id = ?";
                                    $countStmt = $conn->prepare($countQuery);
                                    $countStmt->bind_param("i", $user__id);
                                    $countStmt->execute();
                                    $countStmt->bind_result($follows_count);

                                    $countStmt->fetch();
                                    $countStmt->close();
                                    ?>
                                    <div class="account">
                                    <a style="color: black; text-decoration:none;"
                                        href="../account/?id=<?php echo $user__id; ?>"><img class="pic" src="<?php if (!empty($picture)) {
                                                echo "data:image/jpeg;base64," . base64_encode($picture);
                                            } else {
                                                echo "../assets/default_pic.png";
                                            } ?>">
                                        <?php if ($badge_vip) {
                                            echo '<div class="badge-vip"></div>';
                                        } ?>
                                        <?php if ($badge_certif) {
                                            echo '<div class="badge-certif"></div>';
                                        } ?>
                                        <?php if ($badge_official) {
                                            echo '<div class="badge-official"></div>';
                                        } ?>
                                        <h3 class="username" style="text-transform: capitalize;">
                                            <?php echo $username; ?><br>
                                            <?php
                                            if ($checkResult->num_rows > 0) {
                                                echo "<a href='../home/follow.php?to_id=" . $user__id . "'><button
                                                style='border-radius: 3px 0px 0px 3px; margin-left: -1px; color: #121212;' class='disabled'>$ts_followed</button></a><button class='disabled'
                                                    style='border-radius: 0px 3px 3px 0px; margin-left: -3px; color: #121212;'>$follows_count</button>";
                                            } else {
                                                echo "<a href='../home/follow.php?to_id=" . $user__id . "'><button
                                                style='border-radius: 3px 0px 0px 3px; margin-left: -1px; color: #121212;'>$ts_follow</button></a><button class='disabled'
                                                    style='border-radius: 0px 3px 3px 0px; margin-left: -3px; color: #121212;'>$follows_count</button>";
                                            }
                                            ?>
                                    </h3>
                                    </a>
                                    </div>
                                    <?php
                                }
                            }

                            ?>
                    </div>
                    <br>
                    <hr><br>
                    <!-- Recents Twists -->
                    <h2><?php echo $ts_recents_twists ?> :</h2>
                    <div class="twists-list">
                        <?php
                        $sql = "SELECT user_id, enterprise_id, text, datetime, id, reply_to FROM posts ORDER BY datetime DESC LIMIT 8";
                        $result = $conn->query($sql);
                        // Fetch boucle
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $id = $row["user_id"];
                                $query = "SELECT username, picture, badge_certif, badge_vip, badge_official FROM users WHERE id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $stmt->bind_result($username, $u_picture, $certif, $vip, $official);
                                $stmt->fetch();
                                $stmt->close();
                                $username = htmlspecialchars($username);
                                $company_id = $row["enterprise_id"];
                                $text = $row["text"];
                                $post_id = $row["id"];
                                $reply_to = $row["reply_to"];
                                $datetime = $row["datetime"];
                                if ($company_id == 0) { ?>
                                    <div class="twist">
                                        <a style="color: black; text-decoration:none;" href="<?php echo "../account?id=" . $id; ?>">
                                            <?php include "../assets/imgprofile.php" ?>
                                            <h3 class="username" style="text-transform: capitalize;">
                                                <?php echo $username; ?>
                                                <?php $checkQuery = "SELECT * FROM follows WHERE from_id = ? AND to_id = ?";
                                                $checkStmt = $conn->prepare($checkQuery);
                                                $checkStmt->bind_param("ii", $_SESSION["id"], $id);
                                                $checkStmt->execute();
                                                $checkResult = $checkStmt->get_result();
                                                $countQuery = "SELECT COUNT(*) FROM follows WHERE to_id = ?";
                                                $countStmt = $conn->prepare($countQuery);
                                                $countStmt->bind_param("i", $id);
                                                $countStmt->execute();
                                                $countStmt->bind_result($follows_count);

                                                $countStmt->fetch();
                                                $countStmt->close();
                                                if ($checkResult->num_rows > 0) {
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button class='disabled' style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>$ts_followed</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
                                                } else {
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>$ts_follow</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
                                                } ?>
                                            </h3>
                                        </a>
                                        <p class="text">
                                            <?php
                                            if ($reply_to) {
                                                $query = "SELECT text, user_id FROM posts WHERE id = ?";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bind_param("i", $reply_to);
                                                $stmt->execute();
                                                $stmt->bind_result($reply_text, $reply_user_id);
                                                $stmt->fetch();
                                                $stmt->close();

                                                $query = "SELECT username FROM users WHERE id = ?";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bind_param("i", $reply_user_id);
                                                $stmt->execute();
                                                $stmt->bind_result($reply_username);
                                                $stmt->fetch();
                                                $stmt->close();
                                                echo "<bold>In reply at <a href='../account?id=" . $reply_user_id . "'>@" . $reply_username . "</a> : <a href='../post?post_id=" . $reply_to . "'>" . $reply_text . "</a></bold><br>";
                                            }
                                            echo $text;
                                            ?>
                                        <div class="flex right">
                                            <bold>
                                                <?php
                                                echo $datetime;
                                                ?>
                                            </bold>
                                            <?php include '../components/counter.php'; ?>
                                        </div>
                                        <br>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div><br>
                    <hr><br>
                    <script src="//servedby.eleavers.com/ads/ads.php?t=Mjk4NjM7MjAxMzE7aG9yaXpvbnRhbC5iYW5uZXI=&index=1"></script>
                    <h2><?php echo $ts_liked_twists ?> :</h2>
                    <div class="twists-list">
                        <?php
                        $sql_most_liked = "SELECT p.user_id, p.enterprise_id, p.text, p.datetime, p.id, p.reply_to, COUNT(l.id) AS like_count
                                        FROM posts p
                                        LEFT JOIN likes l ON p.id = l.to_post_id
                                        GROUP BY p.id
                                        ORDER BY like_count DESC
                                        LIMIT 8";
                        $result_most_liked = $conn->query($sql_most_liked);

                        if ($result_most_liked->num_rows > 0) {
                            while ($row_most_liked = $result_most_liked->fetch_assoc()) {
                                $id = $row_most_liked["user_id"];
                                $row = $row_most_liked;
                                $query = "SELECT username, picture, badge_certif, badge_vip, badge_official FROM users WHERE id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $stmt->bind_result($username, $u_picture, $certif, $vip, $official);
                                $stmt->fetch();
                                $stmt->close();
                                $username = htmlspecialchars($username);
                                $company_id = $row["enterprise_id"];
                                $text = $row["text"];
                                $post_id = $row["id"];
                                $reply_to = $row["reply_to"];
                                $datetime = $row["datetime"];
                                if ($company_id == 0) { ?>
                                    <div class="twist">
                                        <a style="color: black; text-decoration:none;" href="<?php echo "../account?id=" . $id; ?>">
                                            <?php include "../assets/imgprofile.php" ?>
                                            <h3 class="username" style="text-transform: capitalize;">
                                                <?php echo $username; ?>
                                                <?php $checkQuery = "SELECT * FROM follows WHERE from_id = ? AND to_id = ?";
                                                $checkStmt = $conn->prepare($checkQuery);
                                                $checkStmt->bind_param("ii", $_SESSION["id"], $id);
                                                $checkStmt->execute();
                                                $checkResult = $checkStmt->get_result();
                                                $countQuery = "SELECT COUNT(*) FROM follows WHERE to_id = ?";
                                                $countStmt = $conn->prepare($countQuery);
                                                $countStmt->bind_param("i", $id);
                                                $countStmt->execute();
                                                $countStmt->bind_result($follows_count);

                                                $countStmt->fetch();
                                                $countStmt->close();
                                                if ($checkResult->num_rows > 0) {
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button class='disabled' style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>$ts_followed</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
                                                } else {
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>$ts_follow</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
                                                } ?>
                                            </h3>
                                        </a>
                                        <p class="text">
                                            <?php
                                            if ($reply_to) {
                                                $query = "SELECT text, user_id FROM posts WHERE id = ?";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bind_param("i", $reply_to);
                                                $stmt->execute();
                                                $stmt->bind_result($reply_text, $reply_user_id);
                                                $stmt->fetch();
                                                $stmt->close();

                                                $query = "SELECT username FROM users WHERE id = ?";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bind_param("i", $reply_user_id);
                                                $stmt->execute();
                                                $stmt->bind_result($reply_username);
                                                $stmt->fetch();
                                                $stmt->close();
                                                echo "<bold>In reply at <a href='../account?id=" . $reply_user_id . "'>@" . $reply_username . "</a> : <a href='../post?post_id=" . $reply_to . "'>" . $reply_text . "</a></bold><br>";
                                            }
                                            echo $text;
                                            ?>
                                        <div class="flex right">
                                            <bold>
                                                <?php
                                                echo $datetime;
                                                ?>
                                            </bold>
                                            <?php include '../components/counter.php'; ?>
                                        </div>
                                        <br>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div><br>
                    <hr><br>
                    <h2><?php echo $ts_active_accounts ?> :</h2>
                    <div class="accounts_list">
                        <?php
                        $sql_most_active = "SELECT u.id, u.username, u.picture, u.badge_official, u.badge_certif, u.badge_vip, COUNT(p.id) AS post_count
                                            FROM users u
                                            LEFT JOIN posts p ON u.id = p.user_id
                                            GROUP BY u.id
                                            ORDER BY post_count DESC
                                            LIMIT 20";
                        $result_most_active = $conn->query($sql_most_active);

                        if ($result_most_active->num_rows > 0) {
                            while ($row_most_active = $result_most_active->fetch_assoc()) {
                                $user_id = $row_most_active["id"];
                                $username = $row_most_active["username"];
                                $picture = $row_most_active["picture"];
                                $badge_certif = $row_most_active["badge_certif"];
                                $badge_vip = $row_most_active["badge_vip"];
                                $badge_official = $row_most_active["badge_official"];
                                $post_count = $row_most_active["post_count"];
                                ?>
                                <div class="account">
                                    <a style="color: black; text-decoration:none;" href="../account/?id=<?php echo $user_id; ?>">
                                        <img class="pic" src="<?php if (!empty($picture)) {
                                            echo "data:image/jpeg;base64," . base64_encode($picture);
                                        } else {
                                            echo "../assets/default_pic.png";
                                        } ?>">
                                        <?php if ($badge_vip) {
                                            echo '<div class="badge-vip"></div>';
                                        } ?>
                                        <?php if ($badge_certif) {
                                            echo '<div class="badge-certif"></div>';
                                        } ?>
                                        <?php if ($badge_official) {
                                            echo '<div class="badge-official"></div>';
                                        } ?>
                                        <h3 class="username" style="text-transform: capitalize;">
                                            <?php echo $username; ?><br>
                                            <span>Posts: <?php echo $post_count; ?></span>
                                        </h3>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <br>
                    <hr><br>
                    <h2><?php echo $ts_reply_twists ?> :</h2>
                    <div class="twists-list">
                        <?php
                        $sql_most_liked = "SELECT p.user_id, p.enterprise_id, p.text, p.datetime, p.id, p.reply_to, COUNT(l.id) AS reply_count
                                        FROM posts p
                                        LEFT JOIN posts l ON p.id = l.reply_to
                                        GROUP BY p.id
                                        ORDER BY reply_count DESC
                                        LIMIT 8";
                        $result_most_liked = $conn->query($sql_most_liked);

                        if ($result_most_liked->num_rows > 0) {
                            while ($row_most_liked = $result_most_liked->fetch_assoc()) {
                                $id = $row_most_liked["user_id"];
                                $row = $row_most_liked;
                                $query = "SELECT username, picture, badge_certif, badge_vip, badge_official FROM users WHERE id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $stmt->bind_result($username, $u_picture, $certif, $vip, $official);
                                $stmt->fetch();
                                $stmt->close();
                                $username = htmlspecialchars($username);
                                $company_id = $row["enterprise_id"];
                                $text = $row["text"];
                                $post_id = $row["id"];
                                $reply_to = $row["reply_to"];
                                $datetime = $row["datetime"];
                                if ($company_id == 0) { ?>
                                    <div class="twist">
                                        <a style="color: black; text-decoration:none;" href="<?php echo "../account?id=" . $id; ?>">
                                            <?php include "../assets/imgprofile.php" ?>
                                            <h3 class="username" style="text-transform: capitalize;">
                                                <?php echo $username; ?>
                                                <?php $checkQuery = "SELECT * FROM follows WHERE from_id = ? AND to_id = ?";
                                                $checkStmt = $conn->prepare($checkQuery);
                                                $checkStmt->bind_param("ii", $_SESSION["id"], $id);
                                                $checkStmt->execute();
                                                $checkResult = $checkStmt->get_result();
                                                $countQuery = "SELECT COUNT(*) FROM follows WHERE to_id = ?";
                                                $countStmt = $conn->prepare($countQuery);
                                                $countStmt->bind_param("i", $id);
                                                $countStmt->execute();
                                                $countStmt->bind_result($follows_count);

                                                $countStmt->fetch();
                                                $countStmt->close();
                                                if ($checkResult->num_rows > 0) {
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button class='disabled' style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>$ts_followed</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
                                                } else {
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>$ts_follow</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
                                                } ?>
                                            </h3>
                                        </a>
                                        <p class="text">
                                            <?php
                                            if ($reply_to) {
                                                $query = "SELECT text, user_id FROM posts WHERE id = ?";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bind_param("i", $reply_to);
                                                $stmt->execute();
                                                $stmt->bind_result($reply_text, $reply_user_id);
                                                $stmt->fetch();
                                                $stmt->close();

                                                $query = "SELECT username FROM users WHERE id = ?";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bind_param("i", $reply_user_id);
                                                $stmt->execute();
                                                $stmt->bind_result($reply_username);
                                                $stmt->fetch();
                                                $stmt->close();
                                                echo "<bold>In reply at <a href='../account?id=" . $reply_user_id . "'>@" . $reply_username . "</a> : <a href='../post?post_id=" . $reply_to . "'>" . $reply_text . "</a></bold><br>";
                                            }
                                            echo $text;
                                            ?>
                                        <div class="flex right">
                                            <bold>
                                                <?php
                                                echo $datetime;
                                                ?>
                                            </bold>
                                            <?php include '../components/counter.php'; ?>
                                        </div>
                                        <br>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div><br>
                </div>
            </div>
            <hr>
            <?php include "../components/footer.php" ?>
        </div>
    </div>
    <script>
        var container = document.getElementById('container');
        container.style.height = Math.max(window.innerHeight, container.scrollHeight) + 'px';
    </script>
</body>

</html>