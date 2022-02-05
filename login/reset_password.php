<?php
session_start();
require ($_SERVER['DOCUMENT_ROOT']."db/db_connection.php");
UserVerification::checkIfUserIsLoggedIn();

    $user_verification = new UserVerification();
    $new_password = '';
    $confirm_password = '';
    $password_err = '';
    $confirm_password_err = '';

    function areDataValid(): bool
    {
        global $password_err, $confirm_password_err;
        return empty($password_err) && empty($confirm_password_err);
    }

    function resetPassword(){
        global $password_err, $confirm_password_err, $new_password, $user_verification, $mysqli;
        $user_verification->getPasswordFormData($new_password, $password_err);
        $user_verification->confirmPassword($new_password, $confirm_password_err, $confirm_password);
        if(areDataValid()){
            $sql = db_service::resetPassword();
            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("si", $param_password, $param_id);
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                $param_id = $_SESSION["id"];
                if($stmt->execute()){
                    session_destroy();
                    header("location: login/login.php");
                    exit();
                } else{
                    echo "Oops! Później...";
                }
                $stmt->close();
            }
        }
        $mysqli->close();
    }
    resetPassword();
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
            <label>Nowe pasło</label>
            <input type="password" name="new_password" class="form-control <?php echo (!empty($this->errors->password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $this->new_password; ?>">
            <span class="invalid-feedback"><?php echo $this->errors->password_err; ?></span>
</div>
<div class="form-group">
    <label>Potwierdź pasło</label>
    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($this->errors->confirm_password_err)) ? 'is-invalid' : ''; ?>">
    <span class="invalid-feedback"><?php echo $this->errors->confirm_password_err; ?></span>
</div>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Submit">
    <a class="btn btn-link ml-2" href="../welcome_page.php">Anuluj</a>
</div>
</form>
</div>
</body>
</html>