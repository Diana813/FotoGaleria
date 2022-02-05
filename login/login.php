<?php

class Login {
    public string $password = '';
    public string $username = '';
    public string $username_err = '';
    public string $password_err = '';
    public string $login_err = '';


    public function checkIfUserIsLogged(){
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("location: ../welcome_page.php");
            exit;
        }
    }

    private function getUsername(){
        if(empty(trim($_POST["username"]))){
            $this->username_err = "Wpisz nazwę użytkownika.";
        } else{
            $this->username = trim($_POST["username"]);
        }
    }

    private function getPassword(){
        if(empty(trim($_POST["password"]))){
            $this->password_err = "Wpisz swoje hasło.";
        } else{
            $this->password = trim($_POST["password"]);
        }
    }

    private function areDataValid(): bool
    {
        return empty($this->username_err) && empty($this->password_err);
    }

    private function userExist($stmt): bool
    {
        return  $stmt->num_rows == 1;
    }

    public function loginUser(mysqli $mysqli){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $this->getUsername();
            $this->getPassword();
            if($this->areDataValid()){
                $sql = db_service::selectUserData();
                if($stmt = $mysqli->prepare($sql)){
                    $stmt->bind_param("s", $param_username);
                    $param_username =  $this->username;
                    if($stmt->execute()){
                        $stmt->store_result();
                        if($this->userExist($stmt)){
                            $stmt->bind_result($id, $this->username, $hashed_password);
                            if($stmt->fetch()){
                                if(password_verify($this->password, $hashed_password)){
                                    session_start();
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $this->username;
                                    header("location: ../welcome_page.php");
                                } else{
                                    $this->login_err = "Nieprawidłowe hasło.";
                                }
                            }
                        } else{
                            $this->login_err = "Nieprawidłowa nazwa użytkownika lub hasło.";
                        }
                    } else{
                        echo "Oops! Nie siadło...";
                    }

                    $stmt->close();
                }
            }
        }
    }
}
