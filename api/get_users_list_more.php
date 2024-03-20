<?php include '../connect.php'; ?>

<?php

session_start();

// Query

try {
    $query = "SELECT id FROM users ORDER BY id";
    $result = $conn->query($query);

    $response = "{'error': False, 'users': [";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $query = "SELECT username, biography, creation_date, id, visits, picture, badge_vip, badge_certif, badge_official, company_id FROM users WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($u_username, $u_biography, $u_creation_date, $u_id, $u_visits, $u_picture, $u_vip, $u_certif, $u_official, $u_company_id);
            $stmt->fetch();
            $stmt->close();
            $response = $response . <<<END
                {
                    "username": "$u_username",
                    "biography": "$u_biography",
                    "creation_date": "$u_creation_date",
                    "id": $u_id,
                    "visits": $u_visits,
                    "badges": {
                        "vip": $u_vip,
                        "certif": $u_certif,
                        "official": $u_official
                    },
                    "company_id": $u_company_id
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