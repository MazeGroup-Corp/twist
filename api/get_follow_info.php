<?php include '../connect.php'; ?>

<?php

session_start();

// Query

if (isset($_GET["id"])){
    try{
        $query = "SELECT id, from_id, to_id, datetime FROM follows WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET["id"]);
        $stmt->execute();
        $stmt->bind_result($id, $from_id, $to_id, $datetime);
        $stmt->fetch();
        $stmt->close();
        echo <<<END
        {
            "error": False,
            "id": $id,
            "from_id": $from_id,
            "to_id": $to_id,
            "datetime": "$datetime"
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