<div class="block navbar" style="width:100%;">
    <div class="left flex">
        <a href="../"><img src="../assets/logo_v1.png" alt="Twist Logo" class="logo"></a>
        <!--<h3 class="title">Home</h3>-->
    </div>
    <div class="right flex">
        <a href="../home"><button class="block">Home</button></a>
        <?php echo '<a href="../account/?id='.$_SESSION['id'].'"><button class="block">Account</button></a>';
        if ($_SESSION['company_id'] != 0){
            echo '<a href="../company/index.php?id='. $_SESSION["company_id"] .'"><button class="block">Company</button></a>';
        }
        ?>
        <a href="../logout.php"><button class="block">Log out</button></a>
    </div>
</div>
