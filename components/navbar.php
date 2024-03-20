<?php include '../components/translate.php'; ?>

<div class="block navbar" style="width:100%;">
    <div class="left flex">
        <a href="../"><img src="../assets/logo_v1.png" alt="Twist Logo" class="logo"></a>
        <!--<h3 class="title">Home</h3>-->
    </div>
    <div class="right flex">
        <a href="../home"><button class="block"><?php echo $ts_home ?></button></a>
        <?php 
        if(isset($_SESSION["connected"])){
            if($_SESSION["connected"] == TRUE){
                echo '<a href="../center"><button class="block">'.$ts_center.'</button></a>';
                echo '<a href="../account/?id='.$_SESSION['id'].'"><button class="block">'.$ts_account.'</button></a>';
            }
        }
        
        if ($_SESSION['company_id'] != 0){
            if(isset($_SESSION["connected"])){if($_SESSION["connected"] == TRUE){ echo '<a href="../company/index.php?id='. $_SESSION["company_id"] .'"><button class="block">'.$ts_company.'</button></a>'; }}
        }
        if(isset($_SESSION["connected"])){
            if($_SESSION["connected"] == TRUE){
                echo'<a href="../auto/connexion.php?change_account=1"><button class="block">'.$ts_account_change.'</button></a>';
                echo'<a href="../logout.php"><button class="block">'.$ts_logout.'</button></a>';
            }
            else {
                echo '<a href="../welcome/index.php"><button class="block">'.$ts_lr.'</button></a>';
            }
        }else {
                echo '<a href="../welcome/index.php"><button class="block">'.$ts_lr.'</button></a>';
        }
        ?>
    </div>
</div>