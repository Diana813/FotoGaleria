<?php

class DbService
{
    public static function selectUserData(): string
    {
        return "SELECT id, username, password FROM users WHERE username = ?";
    }

    public static function selectUser(): string
    {
        return "SELECT id FROM users WHERE username = ?";
    }

    public static function insertUser(): string
    {
        return "INSERT INTO users (username, password) VALUES (?, ?)";
    }

    public static function resetPassword(): string
    {
        return "UPDATE users SET password = ? WHERE id = ?";
    }
}