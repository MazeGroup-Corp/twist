<?php

session_start();

if (isset($_SESSION['connected'])) {
    if ($_SESSION['connected'] == true) {
    } else {
        header("Location: ../");
    }
} else {
    header("Location: ../");
}

?>

<?php include '../connect.php'; ?>

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
                <?php echo "Hello, " . $_SESSION['username']; ?>
            </h1>
            <hr>
            <div class="sections">
                <div class="part2 _">
                    <div class="insight-post-section">
                        <h2>Post a Insight :</h2>

                        <form method="POST" action="/home/act.php">
                            <label for="text">Insight text :</label><br>
                            <input type="text" id="text" required name="text" minlength="3" maxlength="80"
                                placeholder="Lenght : 3 to 80" class="glass"><br>
                            <button type="sumbit" name="insight_post" class="glass">Post</button>
                            <?php
                            if (isset($_GET['ins_inp_err'])) {
                                $err = htmlspecialchars($_GET['ins_inp_err']);

                                switch ($err) {
                                    case 'len_text':
                                        ?>
                                        <red>
                                            The text lenght must be between 3 and 80 characters
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
                        <h2>Post a Twist :</h2>

                        <form method="POST" action="/home/act.php">
                            <label for="text">Post text :</label><br>
                            <textarea cols="24" rows="4" id="text" required name="text" minlength="3" maxlength="200"
                                placeholder="Lenght : 3 to 200" class="glass"></textarea><br>
                            <button type="sumbit" name="twist_post" class="glass">Post</button>
                            <?php
                            if ($_SESSION['company_id'] != 0) {
                                ?>
                                <button type="sumbit" name="twist_post_cy" class="glass">Post as a company</button>
                                <?php
                            }
                            if (isset($_GET['post_inp_err'])) {
                                $err = htmlspecialchars($_GET['post_inp_err']);

                                switch ($err) {
                                    case 'len_text':
                                        ?>
                                        <red>
                                            The text lenght must be between 3 and 200 characters
                                        </red>
                                        <?php
                                        break;
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
                <div class="part1">
                    <h2>Recommanded accounts :</h2>
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
                                                style='border-radius: 3px 0px 0px 3px; margin-left: -1px; color: #121212;' class='disabled'>Followed</button></a><button class='disabled'
                                                    style='border-radius: 0px 3px 3px 0px; margin-left: -3px; color: #121212;'>$follows_count</button>";
                                            } else {
                                                echo "<a href='../home/follow.php?to_id=" . $user__id . "'><button
                                                style='border-radius: 3px 0px 0px 3px; margin-left: -1px; color: #121212;'>Follow</button></a><button class='disabled'
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
                    <h2>Recents Twists :</h2>
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
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button class='disabled' style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>Followed</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
                                                } else {
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>Follow</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
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
                    <h2>Most liked Twists :</h2>
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
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button class='disabled' style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>Followed</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
                                                } else {
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>Follow</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
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
                    <h2>Most active accounts :</h2>
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
                    <h2>Most replied Twists :</h2>
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
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button class='disabled' style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>Followed</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
                                                } else {
                                                    echo "<a href='../home/follow.php?to_id=" . $id . "'><button style='border-radius: 3px 0px 0px 3px; margin-right: 0px;'>Follow</button></a><button class='disabled' style='border-radius: 0px 3px 3px 0px; margin-left: -1px; color: #121212;'>" . $follows_count . "</button>";
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