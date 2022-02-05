<?php

class Registration{
    public string $confirm_password = '';
    public string $password = '';
    public string $username = '';
    public string $password_err = '';
    public string $username_err = '';
    public string $confirm_password_err = '';
    private UserVerification $user_verification;

    /**
     * @param $user_verification
     */
    public function __construct($user_verification)
    {
        $this->user_verification = $user_verification;
    }


    private function getUsernameFormData(mysqli $mysqli){
        if(empty(trim($_POST["username"]))){
            $this->username_err = "Przedstaw się.";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
            $this->username_err = "Twoje imię może zawierać tylko litery, cyfry i podkreślenia.";
        } else{
            $sql = db_service::selectUser();
            if($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $param_username);
                $param_username = trim($_POST["username"]);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $this->username_err = "Ktoś już się tak nazywa...";
                    } else {
                        $this->username = trim($_POST["username"]);
                    }
                }
                $stmt->close();
            }
        }
    }

    private function areDataValid(): bool
    {
        return empty($this->username_err) && empty($this->password_err) && empty($this->confirm_password_err);
    }

    public function registerUser(mysqli $mysqli){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $this->getUsernameFormData($mysqli);
            $this->user_verification->getPasswordFormData($this->password, $this->password_err);
            $this->user_verification->confirmPassword($this->password, $this->confirm_password_err, $this->confirm_password);
            if($this->areDataValid()){
                $sql = db_service::insertUser();
                if($stmt = $mysqli->prepare($sql)){
                    $stmt->bind_param("ss", $username, $password);
                    $username = $this->username;
                    $password = password_hash($this->password, PASSWORD_DEFAULT);
                    if($stmt->execute()){
                        header("location: /login/login_file.php");
                    }
                    $stmt->close();
                }
            }
        }
    }
}


