<?php

const DB_SERVER = '212.180.138.42';
const DB_USERNAME = 'webdev-diana-com';
const DB_PASSWORD = 'T{Gb3/+f#6,7z9qp';
const DB_NAME = 'diana_com';

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_error) {
    error_log( ErrorStrings::$db_connection_err. $mysqli->connect_error);
}