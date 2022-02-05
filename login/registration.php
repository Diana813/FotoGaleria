<?php
session_start();

require ($_SERVER['DOCUMENT_ROOT']."db/db_connection.php");

    $confirm_password = '';
    $password = '';
    $username = '';
    $password_err = '';
    $username_err = '';
    $confirm_password_err = '';
    $user_verification = new user_verification();


   function getUsernameFormData(){
       global $username_err, $username;
        if(empty(trim($_POST["username"]))){
            $username_err = "Przedstaw się.";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
            $username_err = "Twoje imię może zawierać tylko litery, cyfry i podkreślenia.";
        } else{
            global $mysqli;
            $sql = db_service::selectUser();
            if($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $param_username);
                $param_username = trim($_POST["username"]);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $username_err = "Ktoś już się tak nazywa...";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                }
                $stmt->close();
            }
        }
    }

    function areDataValid(): bool
    {
        global $username_err, $password_err, $confirm_password_err;
        return empty($username_err) && empty($password_err) && empty($confirm_password_err);
    }

    function registerUser(){
        global $mysqli, $username, $password, $user_verification;
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            getUsernameFormData();
            $user_verification->getPasswordFormData($password, $password_err);
            $user_verification->confirmPassword($password, $confirm_password_err, $confirm_password);
            if(areDataValid()){
                $sql = db_service::insertUser();
                if($stmt = $mysqli->prepare($sql)){
                    $stmt->bind_param("ss", $name, $password);
                    $name = $username;
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    if($stmt->execute()){
                        header("location: login/login.php");
                    } else{
                        echo "Oops! Coś napaciałam - programistka:)";
                    }
                    $stmt->close();
                }
            }
        }
        $mysqli ->close();
    }
    registerUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Zapisz się</h2>
    <p>Wypełnij formularz, żeby utworzyć konto.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control <?php echo ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
</div>
<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control <?php echo ''; ?>" value="<?php echo $password; ?>">
    <span class="invalid-feedback"><?php echo $password_err; ?></span>
</div>
<div class="form-group">
    <label>Confirm Password</label>
    <input type="password" name="confirm_password" class="form-control <?php echo ''; ?>" value="<?php echo $confirm_password; ?>">
    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
</div>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Submit">
    <input type="reset" class="btn btn-secondary ml-2" value="Reset">
</div>
<p>Already have an account? <a href="login.php">Login here</a>.</p>
</form>
</div>
</body>
</html>