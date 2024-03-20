<?php include '../connect.php'; ?>

<?php

session_start();

// Query

try{
    $query = "SELECT id FROM posts ORDER BY id";
    $result = $conn->query($query);

    $response = "{'error': False, 'posts': [";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $query = "SELECT id, user_id, enterprise_id, text, datetime, reply_to FROM posts WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($u_id, $u_user_id, $u_enterprise_id, $u_text, $u_datetime, $u_reply_to);
            $stmt->fetch();
            $stmt->close();
            $response = $response . <<<END
                {
                    "id": $u_id,
                    "user_id": "$u_user_id",
                    "creation_date": "$u_datetime",
                    "text": "$u_text",
                    "reply_to": $u_reply_to,
                    "company_id": $u_enterprise_id
                },
            END;
        }
    }

    $response = $response . "]}";

    echo $response;
} catch (Exception $e) {
    echo <<<END
    {
        "error": True,
        "exception": "$e"
    }
    END;
}
?>