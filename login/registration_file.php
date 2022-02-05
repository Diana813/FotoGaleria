<?php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT']."/db/db_connection.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/db/db_service.php");
require ($_SERVER['DOCUMENT_ROOT'] . "/utils/UserVerification.php");
require ("registration.php");

$user_verification = new UserVerification();
$registration = new Registration($user_verification);
global $mysqli;
$registration->registerUser($mysqli);
$mysqli ->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zarejestruj się</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Zarejestruj się</h2>
    <p>Wypełnij formularz</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Twoja nazwa użytkownika</label>
            <input type="text" name="username" class="form-control <?php echo (!empty($registration->username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $registration->username; ?>">
            <span class="invalid-feedback"><?php echo $registration->username_err; ?></span>
        </div>
        <div class="form-group">
            <label>Hasło</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($registration->password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $registration->password; ?>">
            <span class="invalid-feedback"><?php echo $registration->password_err; ?></span>
        </div>
        <div class="form-group">
            <label>Potwierdź hasło</label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($registration->confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $registration->confirm_password; ?>">
            <span class="invalid-feedback"><?php echo $registration->confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Zatwierdź">
            <input type="reset" class="btn btn-secondary ml-2" value="Resetuj">
        </div>
        <p>Masz już konto? <a href="/login/login_file.php">Zaloguj się</a>.</p>
    </form>
</div>
</body>
</html>