<?php

session_start();

$post_id = $_GET["post_id"];

$_SESSION["reply_to"] = $post_id;

?>

<?php include '../connect.php'; ?>
<?php
if(isset($_SESSION["connected"])){
if($_SESSION["connected"] == TRUE){
$sql = "SELECT blocked FROM users WHERE id = " . $_SESSION['id'] . "";
$resultat = $conn->query($sql);
if ($resultat->num_rows > 0) {
    $row = $resultat->fetch_assoc();
    if ($row['blocked'] == 1) {
        header("Location: ../blocked.php");
        exit();
    }
}}}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twist - Post</title>
    <?php require "../style.php"; ?>
    <link rel="shortcut icon" href="../assets/icon_v1.png" type="image/x-icon">
</head>

<body>
    <div id="container">
        <?php include '../components/navbar.php' ?>
        <div class="page">
            <div class="sections">
                <?php
                    $sql = "SELECT user_id, text, datetime, id, reply_to FROM posts WHERE id = ?";
                    $stmt = $conn->prepare($sql);

                    $stmt->bind_param("i", $post_id);

                    $stmt->execute();

                    $stmt->bind_result($user_id, $text_post, $creation_date, $post_id_, $reply_to);

                    $stmt->fetch();

                    $stmt->close();

                    $id = $user_id;
                    $query = "SELECT username, picture, badge_certif, badge_vip, badge_official  FROM users WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->bind_result($username, $usr_pic, $certif, $vip, $official);
                    $stmt->fetch();
                    $stmt->close();
                    $username = $username;
                    $text = $text_post;
                    $datetime = $creation_date;
                ?>
                <?php
                if(isset($_SESSION["connected"])){
                if($_SESSION["connected"] == TRUE){?>
                <div class="part2 _">
                    <div class="twist-post-section">
                        <h2>Post a reply :</h2>
                        <form method="POST" action="/post/act.php">
                            <label for="text">Reply text :</label>
                            <textarea cols="24" rows="4" id="text" required name="text" minlength="3" maxlength="400"
                                placeholder="Lenght : 3 to 400"></textarea>
                            <button type="sumbit" name="twist_post" class="glass">Reply</button>
                            <?php
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
                    <?php
                    if ($user_id == $_SESSION['id']){
                    ?>
                    <br>
                    <div class="twist-post-section">
                        <h2>Edit your Twist :</h2>
                        <form method="POST" action="<?php echo "/post/act.php?post_id=". $post_id ."" ?>">
                            <label for="text">Reply text :</label>
                            <textarea cols="24" rows="4" id="text" required name="text" minlength="3" maxlength="400"><?php echo $text_post ?></textarea>
                            <button type="sumbit" name="edit_post" class="glass">Edit</button>
                            <?php
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
                    <?php
                    }
                    ?>
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
                }
                ?>
                <div class="part1">
                    <h2>View post :</h2>
                    <div class="twists-list">
                        <div class="twist">
                            <a style="color: black; text-decoration:none;"
                                href="<?php echo "../account?id=" . $id; ?>">
                                <div class="img-box">
                                    <img class="pic" src="<?php if (!empty($usr_pic)) {
                                        echo "data:image/jpeg;base64," . base64_encode($usr_pic);
                                    } else {
                                        echo "../assets/default_pic.png";
                                    } ?>">
                                    <?php if ($vip) {
                                        echo '<div class="badge-vip"></div>';
                                    } ?>
                                    <?php if ($certif) {
                                        echo '<div class="badge-certif"></div>';
                                    } ?>
                                    <?php if ($official) {
                                        echo '<div class="badge-official"></div>';
                                    } ?>
                                </div>
                                <h3 class="username" style="text-transform: capitalize;">
                                    <?php
                                    echo $username;
                                    ?>
                                    <?php
                                    $checkQuery = "SELECT * FROM follows WHERE from_id = ? AND to_id = ?";
                                    $checkStmt = $conn->prepare($checkQuery);
                                    $checkStmt->bind_param("ii", $_SESSION["id"], $id);
                                    $checkStmt->execute();
                                    $checkResult = $checkStmt->get_result();

                                    if ($checkResult->num_rows > 0) {
                                        echo "<a href='../home/follow.php?to_id=" . $id . "'><button class='disabled'>Followed</button></a>";
                                    } else {
                                        echo "<a href='../home/follow.php?to_id=" . $id . "'><button>Follow</button></a>";
                                    }
                                    ?>
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
                                <? include "../components/counter.php"; ?>
                                <?php
                                if (isset($_SESSION['connected'])) {
                                    if ($_SESSION['connected'] == true) {
                                        if ($id == $_SESSION["id"] || $_SESSION['admin'] == 1) {
                                            echo "<a href='../post/delete.php?post_id=" . $post_id_ . "'>Delete</a>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <br>
                            <!-- Replies -->
                            <h3>Replies :</h3>
                            <?php
                            $sql = "SELECT * FROM posts WHERE reply_to = $post_id ORDER BY datetime DESC";
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
                                    $text = $row["text"];
                                    $post_id = $row["id"];
                                    $datetime = $row["datetime"];
                                    $reply_to = $post_id_
                                        ?>
                                    <div class="twist">
                                        <a style="color: black; text-decoration:none;"
                                            href="<?php echo "../account?id=" . $id; ?>" <div class="img-box">
                                            <img class="pic" src="<?php
                                            if (!empty($usr_pic)) {
                                                echo "data:image/jpeg;base64," . base64_encode($usr_pic);
                                            } else {
                                                echo "../assets/default_pic.png";
                                            }
                                            ?>">
                                            <?php if ($vip) {
                                                echo '<div class="badge-vip"></div>';
                                            } ?>
                                            <?php if ($certif) {
                                                echo '<div class="badge-certif"></div>';
                                            } ?>
                                            <?php if ($official) {
                                                echo '<div class="badge-official"></div>';
                                            } ?>
                                    </div>
                                    <h3 class="username" style="text-transform: capitalize;">
                                        <?php
                                        echo $username;
                                        ?>
                                        <?php
                                        $checkQuery = "SELECT * FROM follows WHERE from_id = ? AND to_id = ?";
                                        $checkStmt = $conn->prepare($checkQuery);
                                        $checkStmt->bind_param("ii", $_SESSION["id"], $id);
                                        $checkStmt->execute();
                                        $checkResult = $checkStmt->get_result();

                                        if ($checkResult->num_rows > 0) {
                                            echo "<a href='../account/follow.php?to_id=" . $id . "'><button class='disabled'>Followed</button></a>";
                                        } else {
                                            echo "<a href='../account/follow.php?to_id=" . $id . "'><button>Follow</button></a>";
                                        }
                                        ?>
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
                                        <?php include "../components/counter.php"; ?>
                                    </div>
                                    <br>
                                    <hr>
                                    <?php
                                }
                            } else {
                                echo "No replies";
                            }
                            ?>
                        </div>
                        <?php
                        ?>
                    </div>
                </div>
            </div>
            <br>
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