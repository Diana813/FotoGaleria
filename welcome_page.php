<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . "/utils/UserVerification.php");

UserVerification::checkIfUserIsLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Witaj</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<h1 class="my-5">Cześć, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Witaj na naszej stronie.</h1>
<p>
    <a href="/login/reset_password_file.php" class="btn btn-warning">Resetuj hasło</a>
    <a href="/login/logout.php" class="btn btn-danger ml-3">Wyloguj się</a>
</p>
</body>
</html>