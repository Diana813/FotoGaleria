<?php
session_start();
$_SESSION = array();
session_destroy();
header("location: /login/login_file.php");
exit;

