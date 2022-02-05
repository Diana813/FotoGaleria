<?php

class ResetPassword{
    public UserVerification $user_verification;
    public string $new_password = '';
    public string $confirm_password = '';
    public string $password_err = '';
    public string $confirm_password_err = '';

    /**
     * @param UserVerification $user_verification
     */
    public function __construct(UserVerification $user_verification)
    {
        $this->user_verification = $user_verification;
    }

    private function areDataValid(): bool
    {
        return empty($this->password_err) && empty($this->confirm_password_err);
    }

    public function resetPassword(mysqli $mysqli)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->user_verification->getPasswordFormData($this->new_password, $this->password_err);
            var_dump($this->new_password);
            $this->user_verification->confirmPassword($this->new_password, $this->confirm_password_err,
                $this->confirm_password, $this->password_err);
            var_dump($this->new_password, $this->confirm_password);
            if ($this->areDataValid()) {
                $sql = db_service::resetPassword();
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("si", $param_password, $param_id);
                    $param_password = password_hash($this->new_password, PASSWORD_DEFAULT);
                    $param_id = $_SESSION["id"];
                    if ($stmt->execute()) {
                        session_destroy();
                        header("location: /login/login_file.php");
                        exit();
                    } else {
                        echo "Oops! Później...";
                    }
                    $stmt->close();
                }
            }
        }
    }
}


