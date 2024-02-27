<?php

session_start();

if(isset($_SESSION['connected'])) {
    if ($_SESSION['connected'] == true){} else {
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
        <div id="container">
            <?php include '../assets/navbar.php' ?>
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
                                echo " • <bold style='text-transform: capitalize;'><a style='color: white;' href='../account?id=" . $id . "'>" . $username . "</a></bold> : ";
                                echo $row["message"];
                            }
                        }
                    ?>
                </marquee>
            </div>
            <div class="page">
                <h1 style="text-transform: capitalize;"><?php echo "Hello, " . $_SESSION['username']; ?></h1>
                <hr>
                <div class="sections">
                    <div class="part1">
                        <h2>Recents Companies Twists :</h2>
                        <div class="twists-list">
                            <?php
                            $sql = "SELECT user_id, enterprise_id, text, datetime, id, reply_to FROM posts ORDER BY datetime DESC LIMIT 50";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row["user_id"];
                                $query = "SELECT username, picture, badge_certif, badge_vip, badge_official FROM users WHERE id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $stmt->bind_result($username, $usr_pic, $certif, $vip, $official);
                                $stmt->fetch();
                                $stmt->close();
                                $username = htmlspecialchars($username);
                                $company_id = $row["enterprise_id"];
                                $text = $row["text"];
                                $post_id = $row["id"];
                                $reply_to = $row["reply_to"];
                                $datetime = $row["datetime"]; 
                                if ($company_id != 0) {?>
                                <div class="twist">
                                    <a style="color: black; text-decoration:none;"
                                        href="<?php echo "../account?id=" . $id; ?>">
                                        <div class="img-box">
                                            <img class="pic"
                                                src="<?php if (!empty($usr_pic)) {
                                                    echo "data:image/jpeg;base64," . base64_encode($usr_pic);
                                                } else {
                                                    echo "../assets/default_pic.png";
                                                } ?>">
                                            <?php if ($vip) { echo '<div class="badge-vip"></div>';} ?>
                                            <?php if ($certif) { echo '<div class="badge-certif"></div>';} ?>
                                            <?php if ($official) { echo '<div class="badge-official"></div>';} ?>
                                        </div>
                                        <h3 class="username" style="text-transform: capitalize;"><?php echo $username; ?>
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
                                        } ?></h3>
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
                                    <?php }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="part2">
                        <div class="insight-post-section">
                            <h2>Post a Insight :</h2>
                            
                            <form method="POST" action="/home/act.php">
                                <label for="text">Insight text :</label>
                                <input type="text" id="text" required name="text" minlength="3" maxlength="80" placeholder="Lenght : 3 to 80">
                                <button type="sumbit" name="insight_post">Post</button>
                                <?php
                                    if (isset($_GET['ins_inp_err'])) {
                                        $err = htmlspecialchars($_GET['ins_inp_err']);

                                        switch($err)
                                        {
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
                                <label for="text">Post text :</label>
                                <textarea cols="24" rows="4" id="text" required name="text" minlength="3" maxlength="200" placeholder="Lenght : 3 to 200"></textarea> 
                                <button type="sumbit" name="twist_post">Post</button><button type="sumbit" name="twist_post_cy">Post as a company</button>
                                <?php
                                    if (isset($_GET['post_inp_err'])) {
                                        $err = htmlspecialchars($_GET['post_inp_err']);

                                        switch($err)
                                        {
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
                </div>
                <hr>
                <? include "../assets/footer.php" ?>
            </div>
        </div>
        <script>
            var container = document.getElementById('container');
            container.style.height = Math.max(window.innerHeight, container.scrollHeight) + 'px';
        </script>
    </body>
</html>
