<?php

session_start();

unset($_SESSION['connected']);
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['biography']);
unset($_SESSION['id']);
unset($_SESSION['email']);
unset($_SESSION['creation_date']);

header("Location: ./")

?>