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
<div style="display: flex; justify-content: space-between;">
    <?php
    $rcsql = "SELECT COUNT(*) AS replies FROM posts WHERE reply_to = $post_id";
    $rcresult = $conn->query($rcsql);
    if ($rcresult->num_rows > 0) {
        $rowrc = $rcresult->fetch_assoc();
        $replies = $rowrc["replies"];

        echo '<a href="../post?post_id='. $post_id .'"><button style="border-radius: 3px 0px 0px 3px; margin-right: 0px;"><img src="../assets/Comments.png" width="20"></button></a><button class="disabled" style="border-radius: 0px 3px 3px 0px; height: 29px; margin-left: -1px; color: #121212;">' . $replies . '</button>';
    } else {
        echo "0 Replies";
    }
    ?>
</div>
