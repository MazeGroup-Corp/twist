<?php

session_start();

if(isset($_SESSION['connected'])) {
    if ($_SESSION['connected'] == true){
        header("Location: home");
    } else {
        header("Location: welcome");
    }
} else {
    header("Location: welcome");
}

?>