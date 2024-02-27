<div class="img-box">
    <img class="pic" src="<?php if (!empty($u_picture)) {
        echo "data:image/jpeg;base64," . base64_encode($u_picture);
    } else {
        echo "../assets/default_pic.png";
    } ?>">
    <?php if ($vip) {
        echo '<div class="badge-vip"></div>';
    } ?>
    <?php if ($certif) {
        echo '<div class="badge-certif"></div>';
    } ?>
    <?php if ($official) {
        echo '<div class="badge-official"></div>';
    } ?>
</div>