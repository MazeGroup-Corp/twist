<?php include '../connect.php'; ?>
<?php
session_start();
if (isset($_SESSION['connected'])) {
    if ($_SESSION['connected'] == true) {
    } else {
        header("Location: ../");
    }
} else {
    header("Location: ../");
}
$id_txt = "";
$query = "SELECT name, description, id, logo, owner, creation_date, email FROM companies WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$stmt->bind_result($u_name, $u_description, $u_id, $u_logo, $u_owner, $u_creation_date, $u_email);
$stmt->fetch();
$stmt->close();
$query = "SELECT name, description, id, logo, owner, creation_date, email FROM companies WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($name, $description, $id, $logo, $owner, $creation_date, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twist - Account</title>
    <?php require "../style.php"; ?>
    <link rel="shortcut icon" href="../assets/icon_v1.png" type="image/x-icon">
</head>
<body>
    <div id="container">
        <?php include '../components/navbar.php' ?>
        <div class="page">
            <div class="fullbox">
                <div class="img-box">
                    <img class="pic" src="<?php 
                                        if (!empty($u_logo)) {
                                            echo "data:image/jpeg;base64," . base64_encode($u_logo);
                                        } else {
                                            echo "../assets/default_pic.png";
                                        }
                                        ?>">
                </div>
                <h1 class="username" style="text-transform: capitalize;">
                    <?php echo htmlspecialchars($u_name);?>
                </h1>
                <p class="biography">
                    <?php echo htmlspecialchars($u_description); ?>
                </p>
                <h3 class="creation_date">Creation date : <bold>
                        <?php echo $u_creation_date; ?>
                    </bold>
                </h3>
            </div>
            <br>
            <div class="sections">
                    <div class="part1">
                        <h1 class="username" style="text-transform: capitalize;">
                            <?php echo htmlspecialchars($u_name);?>
                        </h1>
                        <p class="biography">
                        Description : <?php echo htmlspecialchars($u_description); ?><br>
                        Email : <?php echo $u_email; ?></p>
                    </div>
                    <div class="part2">
                        <?php
                        if ($_SESSION['company_id'] == $_GET['id']) { ?>
                        <div class="side-section">
                            <h2>Edit company :</h2>
                            <?php echo '<form method="POST" action="edit.php?id='.$_GET["id"].'" enctype="multipart/form-data">' ?>
                                <label for="username">Name :</label>
                                <input type="text" name="username" id="username" maxlength="16" minlength="3"
                                    placeholder="Lenght : 3 to 16, in lowercase" required class="lower"
                                    value="<?php echo htmlspecialchars($u_name); ?>"><br>
                                <label for="biography">Description :</label><br>
                                <textarea name="biography" id="biography" maxlength="200"
                                    style="max-width: calc(100% - 20px)"
                                    placeholder="Lenght : 200 max"><?php echo $u_description; ?></textarea><br>
                                <label for="profile_pic">Company picture :</label>
                                <input type="file" style="width: calc(100% - 20px);" name="profile_pic" id="profile_pic"
                                    accept="image/png, image/jpeg">
                                <button type="sumbit" name="edit_account">Post</button>
                                <?php
                                if (isset($_GET['account_edit_err'])) {
                                    $err = htmlspecialchars($_GET['account_edit_err']);
                                    switch ($err) {
                                        case 'username_already':
                                            ?>
                                            <red>
                                                The username is already taken
                                            </red>
                                            <?php
                                            break;
                                        case 'len_username':
                                            ?>
                                            <red>
                                                Username lenght must be between 3 and 16
                                            </red>
                                            <?php
                                            break;
                                        case 'len_biography':
                                            ?>
                                            <red>
                                                Biography lenght have 200 characters maximum
                                            </red>
    
                                            <?php
                                            break;
                                        case 'pic_err':
                                            ?>
                                            <red>
                                                Error from the profile picture imported
                                            </red>
                                            <?php
                                            break;
                                    }
                                }
                                ?>
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <hr>
            <?php include "../components/footer.php" ?>
        </div>
    </div>
    <script>
        var container = document.getElementById('container');
        container.style.height = Math.max(window.innerHeight, container.scrollHeight) + 'px';
    </script>
</body>
</html>