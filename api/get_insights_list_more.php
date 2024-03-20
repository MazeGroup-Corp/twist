<?php include '../connect.php'; ?>

<?php

session_start();

// Query

try{
    $query = "SELECT id FROM insights ORDER BY id";
    $result = $conn->query($query);

    $response = "{'error': False, 'insights': [";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $query = "SELECT id, user_id, message FROM insights WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($u_id, $u_user_id, $u_text);
            $stmt->fetch();
            $stmt->close();
            $response = $response . <<<END
                {
                    "id": $u_id,
                    "user_id": "$u_user_id",
                    "text": "$u_text"
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