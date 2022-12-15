<!--
getJSON.php - Extract data from database
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
    <title>Get JSON</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
$limit = 5;

// Check for the limit value
if (isset($_POST['limit'])) {
    $limit = preg_replace('#[^0-9]#', '', $_POST['limit']);
} else {  // a limit variable doesn't exist. 
    $limit = 2;
}

// Set up connection constants
// Using default username and password for AMPPS  
define("SERVER_NAME",   "localhost");
define("DBF_USER_NAME", "root");
define("DBF_PASSWORD",  "mysql");
define("DATABASE_NAME", "consignment");
// Global connection object
$conn = NULL;

// Connect to database
createConnection();

// Get the consignor data from the table
$sql = "SELECT id_consignor,
            fName,
            lName,
            cAddress,
            CONCAT(SUBSTR(cPhone,1,3),'-',SUBSTR(cPhone,4,3),'-',SUBSTR(cPhone,7,4)) AS 'cPhone',
            cDate,
            (SELECT COUNT(*) FROM commission WHERE calledInDate != '1970-01-01' AND checkCreatedDate = '1970-01-01' AND id_consignor = consignor.id_consignor) 
            AS 'checkNeeded', 
            (SELECT COUNT(*) FROM commission WHERE pickUpDate != '1970-01-01' AND id_consignor = consignor.id_consignor) 
            AS 'checkReady', 
            (SELECT COUNT(*) FROM item WHERE itemActive = '1' AND id_consignor = consignor.id_consignor) 
            AS 'activeItems'
            FROM consignor
            ORDER BY id_consignor";
$result = $conn->query($sql);
//displayResult($result, $sql);

// Loop through the $result to create JSON formatted data   
$consignorArray = array();
while ($thisRow = $result->fetch_assoc()) {
    $consignorArray[] = $thisRow;
}

$consignorData = json_encode($consignorArray);

/*************** FUNCTIONS (Alphabetical) *************************/
/* -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
 * createConnection( ) - Create a database connection
 -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - */
function createConnection()
{
    global $conn;
    // Create connection object
    $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Select the database
    $conn->select_db(DATABASE_NAME);
} // end of createConnection( )


/* -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
 * displayResult( ) - Execute a query and display the result
 *    Parameters:  $rs -  result set to display as 2D array
 *                 $sql - SQL string used to display an error msg
 -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  */
function displayResult($result, $sql)
{
    if ($result->num_rows > 0) {
        echo "<table border='1'>\n";
        // print headings (field names)
        $heading = $result->fetch_assoc();
        echo "<tr>\n";
        // print field names 
        foreach ($heading as $key => $value) {
            echo "<th>" . $key . "</th>\n";
        }
        echo "</tr>\n";

        // Print values for the first row
        echo "<tr>\n";
        foreach ($heading as $key => $value) {
            echo "<td>" . $value . "</td>\n";
        }

        // output rest of the records
        while ($row = $result->fetch_assoc()) {
            //print_r($row);
            //echo "<br />";
            echo "<tr>\n";
            // print data
            foreach ($row as $key => $value) {
                echo "<td>" . $value . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    } else {
        echo "<strong>zero results using SQL: </strong>" . $sql;
    }
} // end of displayResult( )
?>
<script>
    var consignorData = <?PHP echo $consignorData?>;
    /* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
     * displayConsignorData( ) - Display contents of JSON data structure
     * = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */
    function displayConsignorData() {
        //document.write("DEBUG Length of consignorList is: " + consignorData.length + "<br />");
        for (var x = 0; x < consignorData.length; x++) {
            document.write(consignorData[x].id_consignor + " ");
            document.write(consignorData[x].fName + " ");
            document.write(consignorData[x].lName + " ");
            document.write(consignorData[x].cPhone + " ");
            document.write(consignorData[x].cDate + " ");
            document.write(consignorData[x].checkNeeded + " ");
            document.write(consignorData[x].checkReady + " ");
            document.write(consignorData[x].activeItems + "<br /><br />");
        }
    } // end of displayConsignorData( )

    /* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
     * displayConsignorTable( ) - Display contents of JSON data structure
     *   using an HTML table for improved UX
     * = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */

    function displayConsignorTable() {
        document.write("<table border='1'>");
        document.write("<tr><th>Person ID</th><th>Name</th><th>Phone</th><th>Date</th><th>Check Needed</th><th>Check Ready</th><th>Active Items</th></tr>")
        for (var x = 0; x < consignorData.length; x++) {
            document.write("<tr>");
            document.write("<td>" + consignorData[x].id_consignor + "</td>");
            document.write("<td>" + consignorData[x].fName + " " + consignorData[x].lName + "</td>");
            document.write("<td>" + consignorData[x].cPhone + "</td>");
            document.write("<td>" + consignorData[x].cDate + "</td>");
            document.write("<td>" + consignorData[x].checkNeeded + "</td>");
            document.write("<td>" + consignorData[x].checkReady + "</td>");
            document.write("<td>" + consignorData[x].activeItems + "</td>");
            document.write("</tr>");
        }
        document.write("</table>");
    } // end of displayConsignorData( )
</script>
<body>

</body>

</html>