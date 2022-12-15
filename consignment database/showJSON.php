<!--
showJSON.php - Present JSON data
Written by Kang Moua
Revised: 12/01/2022
-->

<?PHP 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Data</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?PHP
//echo "PATH (Current Working Directory): " . getcwd( ) . "sunRunLib.php" . "<br />";
require_once(getcwd() . "/getJSON.php");
// Connect to database
createConnection();
?>
<body>
    <div id="frame">
    <header>
        <h1 onclick="location.href='index.html'">Secret Sister Boutique</h1>
    </header>
    <a id='naviTwo' onclick="location.href='showJSON.php'">JSON Data</a>
    <div class='main'>
        <a class='navi' onclick="location.href='createDatabase.php'">Consignor</a>
        <a class='navi' onclick="location.href=''">Order</a>
        <a class='navi' onclick="location.href=''">Item</a>
    </div>
    <h1>JSON Data for Consignor</h1>
        <script>
            displayConsignorTable();
        </script>
    <footer>
        <a onclick="location.href='index.html'" style='text-decoration: underline;'>Main Website</a>
    </footer>
</body>

</html>