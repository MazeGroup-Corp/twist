<?php
function get_post($message_id, $user_id)
{
    // Query

    $query = "SELECT username, picture, badge_certif, badge_vip, badge_official FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
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

    // If user are not company ==
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