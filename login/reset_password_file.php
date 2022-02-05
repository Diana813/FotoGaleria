<?php
session_start();
require ($_SERVER['DOCUMENT_ROOT']."/db/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/db/DbService.php");
require($_SERVER['DOCUMENT_ROOT'] . "/utils/UserVerification.php");
require_once ($_SERVER['DOCUMENT_ROOT']. "/utils/ErrorStrings.php");
require ("reset_password.php");

UserVerification::checkIfUserIsLoggedIn();
$user_verification = new UserVerification();
$reset_password = new ResetPassword($user_verification);
global $mysqli;
$reset_password->resetPassword($mysqli);
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resetuj hasło</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Resetuj hasło</h2>
    <p>Wypełnij, aby zresetować hasło.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Nowe hasło</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($reset_password->password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset_password->new_password; ?>">
            <span class="invalid-feedback"><?php echo $reset_password->password_err; ?></span>
        </div>
        <div class="form-group">
            <label>Potwierdź hasło</label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($reset_password->confirm_password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $reset_password->confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Zatwierdź">
            <a class="btn btn-link ml-2" href="../welcome_page.php">Anuluj</a>
        </div>
    </form>
</div>
</body>
</html>