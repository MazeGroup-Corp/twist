<?php include '../connect.php'; ?>

<?php

session_start();

// Query

$id_txt = "";
$query = "SELECT username, biography, creation_date, id, visits, picture, badge_vip, badge_certif, badge_official, company_id, blocked, admin FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$stmt->bind_result($u_username, $u_biography, $u_creation_date, $u_id, $u_visits, $u_picture, $u_vip, $u_certif, $u_official, $u_company_id, $u_blocked, $u_admin);
$stmt->fetch();
$stmt->close();
$u_visits = $u_visits + 1;
$updateSql = "UPDATE `users` SET visits = $u_visits WHERE id = " . $u_id;
$conn->query($updateSql);
$query = "SELECT username, biography, creation_date, id, visits, picture, badge_vip, badge_certif, badge_official, company_id, blocked FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($username, $biography, $creation_date, $id, $visits, $picture, $vip, $certif, $official, $company_id, $blocked);
$stmt->fetch();
$stmt->close();

?>
<?php
if (isset($_SESSION['connected'])) {
    if ($_SESSION['connected'] == true) {
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
                                        if ($u_blocked == 1){
                                            echo "../assets/accb.png";
                                        }
                                        else if (!empty($u_picture)) {
                                            echo "data:image/jpeg;base64," . base64_encode($u_picture);
                                        } else {
                                            echo "../assets/default_pic.png";
                                        }
                                        ?>">
                    <?php if ($u_vip) { echo '<div class="badge-vip"></div>';} ?>
                    <?php if ($u_certif) { echo '<div class="badge-certif"></div>';} ?>
                    <?php if ($u_official) { echo '<div class="badge-official"></div>';} ?>
                </div>
                <h1 class="username" style="text-transform: capitalize;">
                    <?php 
                    echo htmlspecialchars($u_username);
                    if ($u_blocked == 1){
                        echo "<p style='color: red;'><bold>This account is blocked !</bold></p>";
                    }?>
                    <?php if ($u_company_id != 0){
                        $companySQL = "SELECT name FROM companies WHERE id = ?";
                        $crequest = $conn->prepare($companySQL);

                        $crequest->bind_param("i", $u_company_id);
                        $crequest->execute();

                        $crequest->bind_result($company_name);
                        $crequest->fetch();
                        $crequest->close();

                        echo "<bold style='font-weight: bold;'>of ". $company_name ."</bold>";
                    } ?>
                </h1>
                <p class="biography">
                    <?php echo $u_biography; ?>
                </p>
                <div class="flex_box_pr">
                    <h3 class="followers">
                        <?php
                        $countQuery = "SELECT COUNT(*) FROM follows WHERE to_id = ?";
                        $countStmt = $conn->prepare($countQuery);
                        $countStmt->bind_param("i", $u_id);
                        $countStmt->execute();
                        $countStmt->bind_result($follows_count);

                        $countStmt->fetch();
                        $countStmt->close();

                        echo "".$follows_count." ".$ts_followed."(s)";
                        ?>
                    </h3>
                    <?php
                    $checkQuery = "SELECT * FROM follows WHERE from_id = ? AND to_id = ?";
                    $checkStmt = $conn->prepare($checkQuery);
                    $checkStmt->bind_param("ii", $id, $u_id);
                    $checkStmt->execute();
                    $checkResult = $checkStmt->get_result();

                    if ($checkResult->num_rows > 0) {
                        echo "<a href='../account/follow.php?to_id=" . $u_id . "'><button class='follow_button disabled'>$ts_followed</button></a>";
                    } else {
                        echo "<a href='../account/follow.php?to_id=" . $u_id . "'><button class='follow_button disable'>$ts_follow</button></a>";
                    }
                    ?>
                </div>
                <h3 class="creation_date">Creation date : <bold>
                        <?php echo $u_creation_date; ?>
                    </bold>
                </h3>
            </div>
            <br>
            <div class="sections">
                <div class="part1">
                    <h2 style="text-transform: capitalize;">All
                        <?php echo htmlspecialchars($u_username); ?>'s Twists :
                    </h2>
                    <?php if ($u_blocked == 1){
                        echo "<h3 style='color: red;'><bold>This account is blocked !</bold></h3>";
                        }?>
                    <div class="twists-list">
                        <?php
                        $sql = "SELECT user_id, text, datetime, id, reply_to FROM posts WHERE user_id = '" . $_GET["id"] . "' ORDER BY datetime DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $id = $row["user_id"];
                                $query = "SELECT username, badge_certif, badge_vip, badge_official FROM users WHERE id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $u_id);
                                $stmt->execute();
                                $stmt->bind_result($username, $certif, $vip, $official);
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
                                            if (!empty($u_picture)) {
                                                echo "data:image/jpeg;base64," . base64_encode($u_picture);
                                            } else {
                                                echo "../assets/default_pic.png";
                                            }
                                            ?>">
                                            <?php if ($vip) { echo '<div class="badge-vip"></div>';} ?>
                                            <?php if ($certif) { echo '<div class="badge-certif"></div>';} ?>
                                            <?php if ($official) { echo '<div class="badge-official"></div>';} ?>
                                        </div>
                                        <h3 class="username" style="text-transform: capitalize;">
                                            <?php
                                            echo $username;
                                            ?>
                                            <?php
                                            $checkQuery = "SELECT * FROM follows WHERE from_id = ? AND to_id = ?";
                                            $checkStmt = $conn->prepare($checkQuery);
                                            $checkStmt->bind_param("ii", $_SESSION["id"], $u_id);
                                            $checkStmt->execute();
                                            $checkResult = $checkStmt->get_result();

                                            if ($checkResult->num_rows > 0) {
                                                echo "<a href='../account/follow.php?to_id=" . $u_id . "'><button class='disabled'>$ts_followed</button></a>";
                                            } else {
                                                echo "<a href='../account/follow.php?to_id=" . $u_id . "'><button>$ts_follow</button></a>";
                                            }
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
                                        <?php include "../components/counter.php"; ?>
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
                <div class="part2">
                    <div class="side-section twist-post-section">
                        <h2><?php echo $ts_account_info ?></h2>
                        <?php
                        $query = "SELECT COUNT(*) FROM posts WHERE user_id = ?";

                        $stmt = $conn->prepare($query);

                        $stmt->bind_param("s", $_GET["id"]);

                        $stmt->execute();

                        $stmt->bind_result($nbPosts);

                        $stmt->fetch();

                        $stmt->close();


                        $countQuery = "SELECT COUNT(*) 
                                        FROM likes
                                        JOIN posts ON likes.to_post_id = posts.id
                                        WHERE posts.user_id = ?";

                        $countStmt = $conn->prepare($countQuery);
                        $countStmt->bind_param("i", $u_id);
                        $countStmt->execute();
                        $countStmt->bind_result($total_likes_count);

                        $countStmt->fetch();

                        $countStmt->close();
                        ?>
                        <?php if ($u_blocked == 1){
                        echo "<p style='color: red;'><bold>This account is blocked !</bold></p>";
                        }?>
                        <p><?php echo $ts_total_posts_account ?> :
                            <?php echo $nbPosts; ?>
                        </p>
                        <p><?php echo $ts_total_likes_account ?> :
                            <?php echo $total_likes_count; ?>
                        </p>
                        <p><?php echo $ts_total_visits_account ?> :
                            <?php echo $u_visits; ?>
                        </p>
                    </div>
                    <br>
                    <?php
                    if ($_SESSION['id'] == $_GET['id']) { ?>
                    <div class="side-section twist-post-section">
                        <h2><?php echo $ts_edit_account ?></h2>
                        <?php echo '<form method="POST" action="edit.php?id='.$_GET["id"].'" enctype="multipart/form-data">' ?>
                            <label for="username"><?php echo $ts_username ?> :</label><br>
                            <input type="text" name="username" id="username" maxlength="16" minlength="3"
                                placeholder="Lenght : 3 to 16, in lowercase" required class="lower"
                                value="<?php echo htmlspecialchars($username); ?>"><br>
                            <label for="biography"><?php echo $ts_biography ?> :</label><br>
                            <textarea name="biography" id="biography" maxlength="200"
                                style="max-width: calc(100% - 20px)"
                                placeholder="Lenght : 200 max"><?php echo $biography; ?></textarea><br>
                            <label for="profile_pic"><?php echo $ts_picture_account ?> :</label>
                            <input type="file" style="width: calc(100% - 20px);" name="profile_pic" id="profile_pic"
                                accept="image/png, image/jpeg"><br>
                            <label for="country"><?php echo $ts_country ?></label><br>
                            <select name="country">
                               <option selected value="<?php $_SESSION['country'] ?>"><?php echo $_SESSION['country'] ?></option>
                               <hr>
                               <option value="EN">EN</option>
                               <option value="FR">FR</option>
                            </select><br>
                            <button type="sumbit" name="edit_account"><?php echo $ts_post ?></button>
                            <?php
                            if (isset($_GET['account_edit_err'])) {
                                $err = htmlspecialchars($_GET['account_edit_err']);
                                switch ($err) {
                                    case 'username_already':
                                        ?>
                                        <red>
                                            The username is already taken
                                        </red>
                                        <?php
                                        break;
                                    case 'len_username':
                                        ?>
                                        <red>
                                            Username lenght must be between 3 and 16
                                        </red>
                                        <?php
                                        break;
                                    case 'len_biography':
                                        ?>
                                        <red>
                                            Biography lenght have 200 characters maximum
                                        </red>

                                        <?php
                                        break;
                                    case 'pic_err':
                                        ?>
                                        <red>
                                            Error from the profile picture imported
                                        </red>
                                        <?php
                                        break;
                                }
                            }
                            ?>
                        </form>
                    </div>
                    <?php } ?>
                    <br>
                    <?php
                    if ($_SESSION['admin'] == 1 && $u_admin == 0) { ?>
                    <div class="side-section twist-post-section">
                        <h2>Admin pannel :</h2>
                        <?php if ($u_blocked == 0){
                            echo '<a href="blocked.php?id='.$_GET["id"].'"><button class="disable">Block</button></a>';
                        } else {
                            echo '<a href="unblocked.php?id='.$_GET["id"].'"><button class="disable">Unblock</button></a>';
                        }?>
                    </div>
                    <?php } ?>
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