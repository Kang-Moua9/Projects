<!--
createDb.php - creates database
Written by Kang Moua
Revised: 12/01/2022
-->

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Link to external file
require_once(getcwd() . "/function.php");

// Link to external file
require_once(getcwd() . "/login.php");

// Create connection object
$conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
// Start with a new database to start primary keys at 1
$sql = "DROP DATABASE " . DATABASE_NAME;
runQuery($sql, "DROP " . DATABASE_NAME, false);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS " . DATABASE_NAME;
runQuery($sql, "Creating " . DATABASE_NAME, false);

// Select the database
$conn->select_db(DATABASE_NAME);

/*******************************
 * Create the tables
 *******************************/

// Create Table:consignor
$sql = "CREATE TABLE IF NOT EXISTS consignor (
    id_consignor    INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    fName           VARCHAR(30) NOT NULL,
    lName           VARCHAR(30) NOT NULL,
    cAddress        VARCHAR(40) NOT NULL,
    cPhone          VARCHAR(10) NOT NULL,
    cDate           DATE NOT NULL
    )";
runQuery($sql, "Table:consignor ", false);

// Create Table:commission
$sql = "CREATE TABLE IF NOT EXISTS commission (
    id_commission       INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    id_consignor        INT(10) NOT NULL,  
    commissionDate      DATE NOT NULL, 
    expiredDate         DATE NOT NULL,
    closeDate           DATE DEFAULT NULL,
    calledInDate        DATE DEFAULT NULL,
    checkCreatedDate    DATE DEFAULT NULL, 
    pickUpDate          DATE DEFAULT NULL
    )";
runQuery($sql, "Table:commission", false);

// Create Table:item
$sql = "CREATE TABLE IF NOT EXISTS item (
    id_item         INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    id_consignor    INT(10) NOT NULL, 
    id_commission   INT(10) NOT NULL,  
    itemName        VARCHAR(30) NOT NULL, 
    itemType        VARCHAR(3) NOT NULL,
    itemQuantity    INT(10) NOT NULL,
    itemPrice       DECIMAL(10,2) NOT NULL,
    itemActive      BOOLEAN, 
    itemSold        BOOLEAN, 
    itemDonate      BOOLEAN
    )";
runQuery($sql, "Table:item", false);
?>