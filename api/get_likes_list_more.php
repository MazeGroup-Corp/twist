<?php include '../connect.php'; ?>

<?php

session_start();

// Query

try{
    $query = "SELECT id FROM likes ORDER BY id";
    $result = $conn->query($query);

    $response = "{'error': False, 'likes': [";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $query = "SELECT id, from_id, to_post_id, datetime FROM likes WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($id, $from_id, $to_post_id, $datetime);
            $stmt->fetch();
            $stmt->close();
            echo <<<END
                {
                    "error": False,
                    "id": $id,
                    "from_id": $from_id,
                    "to_post_id": $to_post_id,
                    "datetime": "$datetime"
                }
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