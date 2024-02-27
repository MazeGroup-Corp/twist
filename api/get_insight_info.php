<?php include '../connect.php'; ?>

<?php

session_start();

// Query

if (isset($_GET["id"])){
    try{
        $query = "SELECT id, user_id, message FROM insights WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET["id"]);
        $stmt->execute();
        $stmt->bind_result($u_id, $u_user_id, $u_text);
        $stmt->fetch();
        $stmt->close();
        echo <<<END
        {
            "error": False,
            "id": $u_id,
            "user_id": "$u_user_id",
            "text": "$u_text"
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