<?php

class UserVerification
{
    public static function checkIfUserIsLoggedIn(){
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            header("location: " . $_SERVER["DOCUMENT_ROOT"]."/login/login.php");
            exit;
        }
    }

    public function getPasswordFormData(string &$password, string &$password_err){
        if(empty(trim($_POST["password"]))){
            $password_err = "Wpisz hasło.";
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Hasło musi się składać z co najmniej sześciu znaków.";
        } else{
            $password = trim($_POST["password"]);
        }
    }


    public function confirmPassword(string $password, string &$confirm_password_err, string &$confirm_password){
        if(empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Potwierdź hasło.";
        }else{
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($this->errors->password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Buuu, żle, nieeee.";
            }
        }
    }
}