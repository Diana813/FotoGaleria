<?php
session_start();

require ($_SERVER['DOCUMENT_ROOT']."/db/db_connection.php");

    $password = '';
    $username = '';
    $username_err = '';
    $password_err = '';
    $confirm_password_err = '';
    $login_err = '';

    function checkIfUserIsLogged(){
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("location: " . $_SERVER["DOCUMENT_ROOT"]."../welcome_page.php");
            exit;
        }
    }

    function getUsername(){
        global $username_err, $username;
        if(empty(trim($_POST["username"]))){
            $username_err = "Wpisz nazwę użytkownika.";
        } else{
            $username = trim($_POST["username"]);
        }
    }

    function getPassword(){
        global $password_err, $password;
        if(empty(trim($_POST["password"]))){
            $password_err = "Wpisz swoje hasło.";
        } else{
            $password = trim($_POST["password"]);
        }
    }

   function areDataValid(): bool
    {
        global $username_err, $password_err;
        return (empty($username_err) && empty($password_err));
    }

    function userExist($stmt): bool
    {
       return  $stmt->num_rows == 1;
    }

    function loginUser(){
        global $username, $password, $mysqli, $login_err;
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            getUsername();
            getPassword();
            if(areDataValid()){
                $sql = db_service::selectUser();
                if($stmt = $mysqli->prepare($sql)){
                    $stmt->bind_param("s", $param_username);
                    $param_username =  $username;
                    if($stmt->execute()){
                        $stmt->store_result();
                        if(userExist($stmt)){
                            $stmt->bind_result($id, $username, $hashed_password);
                            if($stmt->fetch()){
                                if(password_verify($password, $hashed_password)){
                                    session_start();
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;
                                    header("location: " . $_SERVER["DOCUMENT_ROOT"]."../welcome_page.php");
                                } else{
                                    $login_err = "Nieprawidłowa nazwa użytkownika lub hasło.";
                                }
                            }
                        } else{
                            $login_err = "Nieprawidłowa nazwa użytkownika lub hasło.";
                        }
                    } else{
                        echo "Oops! Nie siadło...";
                    }

                    $stmt->close();
                }
            }
            $mysqli->close();
        }
    }

checkIfUserIsLogged();
loginUser();

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
    <p>Wypełnij pola.</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="username" class="form-control <?php echo ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group">
            <label>Hasło</label>
            <input type="password" name="password" class="form-control <?php echo ''; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Nie masz konta? <a href="registration.php">Zarejestruj się teraz!</a>.</p>
    </form>
</div>
</body>
</html>