<?php

class ErrorStrings
{
    //login, registration, user_verification
    public static string $username_empty_err = "Wpisz nazwę użytkownika";
    public static string $password_empty_err = "Wpisz swoje hasło";
    public static string $login_err_password = "Nieprawidlowe hasło";
    public static string $login_err = "Nieprawidłowa nazwa użytkownika lub hasło";
    //registration
    public static string $username_wrong_digits_err = "Twoje imię może zawierać tylko litery, cyfry i podkreślenia.";
    public static string $username_taken_err = "Ktoś już się tak nazywa...";
    //user_verification
    public static string $password_too_short_err = "Hasło musi się składać z co najmniej sześciu znaków";
    public static string $confirm_password_empty_err = "Potwierdź hasło";
    public static string $confirm_password_err = "Buuu, żle, nieeee.";

    //db_connection
    public static string $db_connection_err = "Brak kontaktu z bazą: ";

}