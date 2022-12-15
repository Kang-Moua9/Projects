<!--
sampleData.php - inserts sample data into database
Written by Kang Moua
Revised: 12/01/2022
-->

<?PHP
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Link to external file
require_once(getcwd() . "/function.php");

// Populate Table:consignor
$consignorArray = array(
    array('Kang', 'Moua', '123 Green Ave', '1231231233', '2021-11-13'),
    array('Leoo', 'Moua', '123 Green Ave', '1231231233', '2021-11-14'),
    array('Maddy', 'Pelts', '999 Red Ave', '1112223333', '2021-11-16'),
    array('Sam', 'Conel', '123 Blue Ave', '9999999999', '2021-11-20'),
    array('John', 'Conel', '123 Blue Ave', '9999999999', '2021-11-20'),
);

foreach ($consignorArray as $consignor) {
    $sql = "INSERT INTO consignor (id_consignor, fName, lName, cAddress, cPhone, cDate) "
        . "VALUES (NULL, '" . $consignor[0] . "', 
        '" . $consignor[1] . "', 
        '" . $consignor[2] . "', 
        '" . $consignor[3] . "', 
        '" . $consignor[4] . "')";

    //echo "\$sql string is: " . $sql . "<br />";
    runQuery($sql, "New record insert $consignor[4]", false);
}

// Populate Table:commission
$commissionArray = array(
    array(1, '2021-11-13', '2021-12-28', '2021-11-17', '2021-11-18', '2021-11-27', '2021-11-28'),
    array(2, '2021-11-15', '2021-12-30', '2021-11-29', '1970-01-01', '1970-01-01', '1970-01-01'),
    array(1, '2021-11-16', '2021-12-31', '1970-01-01', '1970-01-01', '1970-01-01', '1970-01-01'),
    array(3, '2021-11-16', '2021-12-31', '2021-11-19', '2021-11-20', '2021-11-30', '1970-01-01'),
    array(4, '2021-11-21', '2021-1-5', '1970-01-01', '1970-01-01', '1970-01-01', '1970-01-01'),
);

foreach ($commissionArray as $commission) {
    $sql = "INSERT INTO commission (id_commission, id_consignor, commissionDate, expiredDate, closeDate, calledInDate, checkCreatedDate, pickUpDate) "
        . "VALUES (NULL, '" . $commission[0] . "', 
        '" . $commission[1] . "', 
        '" . $commission[2] . "', 
        '" . $commission[3] . "', 
        '" . $commission[4] . "', 
        '" . $commission[5] . "', 
        '" . $commission[6] . "')";

    //echo "\$sql string is: " . $sql . "<br />";
    runQuery($sql, "New record insert $commission[6]", false);
}

// Populate Table:item
$itemArray = array(
    array(1, 1, 'Asus Laptop', 'D', 1, 385.95, '0', '1', '0'),
    array(1, 1, 'Nike Shoes', 'D', 2, 29.50, '0', '1', '0'),
    array(2, 2, 'HP Keyboard', 'K', 1, 8.89, '0', '1', '0'),
    array(1, 3, 'Bottle', 'PL', 3, 4.25, '1', '0', '0'),
    array(3, 4, 'Pair of Socks', 'K', 6, 10.00, '0', '1', '0'),
    array(4, 5, 'Football', 'D', 2, 5.99, '1', '0', '0')
);

foreach ($itemArray as $item) {
    $sql = "INSERT INTO item (id_item, id_consignor, id_commission, itemName, itemType, itemQuantity, itemPrice, itemActive, itemSold, itemDonate) "
        . "VALUES (NULL, '" . $item[0] . "', 
        '" . $item[1] . "', 
        '" . $item[2] . "', 
        '" . $item[3] . "', 
        '" . $item[4] . "', 
        '" . $item[5] . "', 
        '" . $item[6] . "', 
        '" . $item[7] . "', 
        '" . $item[8] . "')";

    //echo "\$sql string is: " . $sql . "<br />";
    runQuery($sql, "New record insert $item[7]", false);
}
?>