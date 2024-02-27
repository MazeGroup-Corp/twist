<?php include '../connect.php'; ?>

<?php

session_start();

// Query

if (isset($_GET["id"])){
    try{
        $query = "SELECT id, user_id, enterprise_id, text, datetime, reply_to FROM posts WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET["id"]);
        $stmt->execute();
        $stmt->bind_result($u_id, $u_user_id, $u_enterprise_id, $u_text, $u_datetime, $u_reply_to);
        $stmt->fetch();
        $stmt->close();
        echo <<<END
        {
            "error": False,
            "id": $u_id,
            "user_id": "$u_user_id",
            "creation_date": "$u_datetime",
            "text": "$u_text",
            "reply_to": $u_reply_to,
            "company_id": $u_enterprise_id
        }
        END;
    } catch (Exception $e) {
        echo <<<END
        {
            "error": True,
            "exception": "$e"
        }
        END;
    }
} else {
    echo <<<END
    {
        "error": True,
        "exception": "Not id selection."
    }
    END;
}
?>