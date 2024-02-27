<?php include '../connect.php'; ?>

<?php

session_start();

// Query

if (isset($_GET["id"])){
    try{
        $pic_bool = false;
        if (isset($_GET["picture"])){
            if ($_GET["picture"] == "1"){
                $pic_bool = true;
            }
        }
        $query = "SELECT username, biography, creation_date, id, visits, picture, badge_vip, badge_certif, badge_official, company_id FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET["id"]);
        $stmt->execute();
        $stmt->bind_result($u_username, $u_biography, $u_creation_date, $u_id, $u_visits, $u_picture, $u_vip, $u_certif, $u_official, $u_company_id);
        $stmt->fetch();
        $stmt->close();
        if ($pic_bool){
            echo <<<END
            {
                "error": False,
                "username": "$u_username",
                "biography": "$u_biography",
                "creation_date": "$u_creation_date",
                "id": $u_id,
                "visits": $u_visits,
                "picture": "$u_picture",
                "badges": {
                    "vip": $u_vip,
                    "certif": $u_certif,
                    "official": $u_official
                },
                "company_id": $u_company_id
            }
            END;
        } else {
            echo <<<END
            {
                "error": False,
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
            }
            END;
        }
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