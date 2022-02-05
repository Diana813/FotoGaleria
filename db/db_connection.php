<?php

const DB_SERVER = '';
const DB_USERNAME = '';
const DB_PASSWORD = '';
const DB_NAME = '';

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_error) {
    error_log( ErrorStrings::$db_connection_err. $mysqli->connect_error);
}