<?php

    session_start();
    
    require "../connect.php" ;
    
    if (isset($_SESSION['connected'])) {
        if ($_SESSION['connected'] == true) {
            if (isset($_SESSION['connected'])) {
                if ($_SESSION['connected'] == true) {
                    if (isset($_POST['twist_post']) && isset($_SESSION['reply_to'])){
                        if (!empty($_POST['text'])){
                            $er = false;
                            $text = htmlspecialchars($_POST['text']);
                            $text_len = strlen(htmlspecialchars($_POST['text']));
                            $id = $_SESSION['id'];
                            $to_id = $_SESSION['reply_to'];
                            if ($text_len >= 3 && $text_len <= 400){} else {
                                $er = true;
                                header("Location: .?post_inp_err=len_text");
                            }
                            if ($er == false){
                                $sql = "INSERT INTO posts (user_id, text, datetime, reply_to) VALUES ('$id', '$text', NOW(), '$to_id')";
                                $result = $conn->query($sql);
                                header("Location:" . $_SERVER['HTTP_REFERER']);
                            }
                        }
                    }
                    
                    if (isset($_POST['edit_post'])){
                        $post_id = $_GET["post_id"];
                        $sql = "SELECT user_id FROM posts WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $post_id);
                        $stmt->execute();
                        $stmt->bind_result($user_id);
                        $stmt->fetch();
                        $stmt->close();
                        if ($user_id == $_SESSION['id']){
                            if (!empty($_POST['text'])){
                                $er = false;
                                $text = htmlspecialchars($_POST['text']);
                                $text_len = strlen(htmlspecialchars($_POST['text']));
                                if ($text_len >= 3 && $text_len <= 400){} else {
                                    $er = true;
                                    header("Location: .?post_inp_err=len_text");
                                }
                                if ($er == false){
                                    if ($er == false){
                                        if ($er == false){
                                            $updateQuery = "UPDATE posts SET text='$text' WHERE id=" . $post_id;
                                            $result = mysqli_query($conn, $updateQuery);
                                            header("Location:" . $_SERVER['HTTP_REFERER']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>