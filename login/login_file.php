<?php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT']."/db/db_connection.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/db/db_service.php");
require ("login.php");

$password = $username = '';
$login = new Login();
$login->checkIfUserIsLogged();
global $mysqli;
$login->loginUser($mysqli);
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Login</h2>
    <p>Wypełnij formularz, żeby się zalogować.</p>

    <?php
    if(!empty($login->login_err)){
        echo '<div class="alert alert-danger">' . $login->login_err . '</div>';
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Twoja nazwa użytkownika</label>
            <input type="text" name="username" class="form-control <?php echo (!empty($login->username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $login->username; ?>">
            <span class="invalid-feedback"><?php echo $login->username_err; ?></span>
        </div>
        <div class="form-group">
            <label>Hasło</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($login->password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $login->password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Nie masz konta? <a href="/login/registration_file.php">Zarejestruj się!</a>.</p>
    </form>
</div>
</body>
</html>