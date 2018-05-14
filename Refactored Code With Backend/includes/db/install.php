<?php
require_once('config.php');

// Connect to database
$db_name = DB_NAME;
$db_user = DB_USER;
$db_pass = DB_PASS;
$db_charset = DB_CHARSET;
$db_host = DB_HOST;

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";
$options = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
        );

$db = new PDO($dsn, $db_user, $db_pass, $options);

// Create table
$db->query( "CREATE TABLE IF NOT EXISTS users (
        ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(255) NOT NULL,
        name VARCHAR(30),
        email VARCHAR(255)
    )");
    
$db->query( "CREATE TABLE IF NOT EXISTS auth_tokens (
        ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        selector CHAR(16),
        token CHAR(64),
        expires DATETIME
    )");
    
$db->query( "CREATE TABLE IF NOT EXISTS password_reset (
        ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255),
        selector CHAR(16),
        token CHAR(64),
        expires BIGINT(20)
    )");