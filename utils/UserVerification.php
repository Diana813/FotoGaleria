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
            $password_err = ErrorStrings::$password_empty_err;
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = ErrorStrings::$password_too_short_err;
        } else{
            $password = trim($_POST["password"]);
        }
    }


    public function confirmPassword(string $password, string &$confirm_password_err, string &$confirm_password, string $password_err){
        if(empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = ErrorStrings::$confirm_password_empty_err;
        }else{
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = ErrorStrings::$confirm_password_err;
            }
        }
    }
}