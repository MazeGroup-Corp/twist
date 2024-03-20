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

?>

<?php include '../connect.php'; ?>
<?php
$sql = "SELECT blocked FROM users WHERE id = ". $_SESSION['id'] ."";
$resultat = $conn->query($sql);
if ($resultat->num_rows > 0) {
    $row = $resultat->fetch_assoc();
    if ($row['blocked'] == 1) {
        header("Location: ../blocked.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twist - Center</title>
    <?php require "../style.php"; ?>
    <link rel="shortcut icon" href="../assets/icon_v1.png" type="image/x-icon">
</head>

<body>

    <!-- Nabar -->

    <div id="container">
        <?php include '../components/navbar.php' ?>
        <div class="block navbar" style="width:100%;">
            <div class="left flex">
                <h3 class="title" style="margin-left: 10px;">Twist center</h3>
            </div>
            <div class="right flex">
                <a href="../discover/"><button class="block">Discover</button></a>
                <a href="../search/"><button class="block">Search</button></a>
                <a href="../wiki/"><button class="block">Wiki</button></a>
            </div>
        </div>

        <hr>
        <?php include "../components/footer.php" ?>
    </div>
    <script>
        var container = document.getElementById('container');
        container.style.height = Math.max(window.innerHeight, container.scrollHeight) + 'px';
    </script>
</body>

</html>