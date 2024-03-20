<?php include '../connect.php'; ?>
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
$id_txt = "";
$query = "SELECT name, description, id, logo, owner, creation_date FROM companies WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$stmt->bind_result($u_name, $u_description, $u_id, $u_logo, $u_owner, $u_creation_date);
$stmt->fetch();
$stmt->close();
$query = "SELECT name, description, id, logo, owner, creation_date FROM companies WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($name, $description, $id, $logo, $owner, $creation_date);
$stmt->fetch();
$stmt->close();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twist - Account</title>
    <?php require "../style.php"; ?>
    <link rel="shortcut icon" href="../assets/icon_v1.png" type="image/x-icon">
</head>
<body>
    <div id="container">
        <?php include '../components/navbar.php' ?>
        <div class="page">
            <div class="fullbox">
                <div class="img-box">
                    <img class="pic" src="<?php 
                                        if (!empty($u_logo)) {
                                            echo "data:image/jpeg;base64," . base64_encode($u_logo);
                                        } else {
                                            echo "../assets/default_pic.png";
                                        }
                                        ?>">
                </div>
                <h1 class="username" style="text-transform: capitalize;">
                    <?php echo htmlspecialchars($u_name);?>
                </h1>
                <p class="biography">
                    <?php echo htmlspecialchars($u_description); ?>
                </p>
                <h3 class="creation_date">Creation date : <bold>
                        <?php echo $u_creation_date; ?>
                    </bold>
                </h3>
            </div>
            <br>
            <div class="sections">
                <div class="part1">
                    <h2 style="text-transform: capitalize;">All
                        <?php echo htmlspecialchars($u_name); ?>'s Twists :
                    </h2>
                    <div class="twists-list">
                        <?php
                        $sql = "SELECT user_id, text, datetime, id, reply_to FROM posts WHERE enterprise_id = '" . $_GET["id"] . "' ORDER BY datetime DESC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $id = $row["user_id"];
                                $query = "SELECT name FROM companies WHERE id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $u_id);
                                $stmt->execute();
                                $stmt->bind_result($username);
                                $stmt->fetch();
                                $stmt->close();
                                $username = htmlspecialchars($username);
                                $text = $row["text"];
                                $post_id = $row["id"];
                                $reply_to = $row["reply_to"];
                                $datetime = $row["datetime"];
                                ?>
                                <div class="twist">
                                    <a style="color: black; text-decoration:none;"
                                        href="<?php echo "../account?id=" . $id; ?>">
                                        <div class="img-box">
                                            <img class="pic" src="<?php
                                            if (!empty($u_logo)) {
                                                echo "data:image/jpeg;base64," . base64_encode($u_logo);
                                            } else {
                                                echo "../assets/default_pic.png";
                                            }
                                            ?>">
                                        </div>
                                        <h3 class="username" style="text-transform: capitalize;">
                                            <?php
                                            echo $username;
                                            ?>
                                        </h3>
                                    </a>
                                    <p class="text">
                                    <?php
                                        if ($reply_to){
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
                                        <div style="display: flex; justify-content: space-between;">
                                            <?php
                                            $checkQuery = "SELECT * FROM likes WHERE from_id = ? AND to_post_id = ?";
                                            $checkStmt = $conn->prepare($checkQuery);
                                            $checkStmt->bind_param("ii", $_SESSION["id"], $post_id);
                                            $checkStmt->execute();
                                            $checkResult = $checkStmt->get_result();
                                            $countQuery = "SELECT COUNT(*) FROM likes WHERE to_post_id = ?";
                                            $countStmt = $conn->prepare($countQuery);
                                            $countStmt->bind_param("i", $post_id);
                                            $countStmt->execute();
                                            $countStmt->bind_result($likes_count);
                                            $countStmt->fetch();
                                            $countStmt->close();
                                            if ($checkResult->num_rows > 0) {
                                                echo '<a href="../home/like.php?to_post_id=' . $post_id . '"><button style="border-radius: 3px 0px 0px 3px; margin-right: 0px;"><img src="../assets/liked.png" width="20"></button></a><button class="disabled" style="border-radius: 0px 3px 3px 0px; height: 29px; margin-left: -1px; color: #121212;">' . $likes_count . '</button>';
                                            } else {
                                                echo '<a href="../home/like.php?to_post_id=' . $post_id . '"><button style="border-radius: 3px 0px 0px 3px; margin-right: 0px;"><img src="../assets/like.png" width="20"></button></a><button class="disabled" style="border-radius: 0px 3px 3px 0px; height: 29px; margin-left: -1px; color: #121212;">' . $likes_count . '</button>';
                                            }
                                            ?>
                                        </div>
                                        <a href="../post?post_id=<?php echo $post_id; ?>">View more</a>
                                    </div>
                                    <br>
                                    <hr>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <hr>
            <? include "../components/footer.php" ?>
        </div>
    </div>
    <script>
        var container = document.getElementById('container');
        container.style.height = Math.max(window.innerHeight, container.scrollHeight) + 'px';
    </script>
</body>
</html>