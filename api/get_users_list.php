<?php include '../connect.php'; ?>

<?php

session_start();

// Query

try{
    $query = "SELECT id FROM users ORDER BY id";
    $result = $conn->query($query);

    $response = "{'error': False, 'users': '";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $response = $response . "$id ";
        }
    }

    $response = $response . "'.split()}";

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