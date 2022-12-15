<!--
function.php - hold functions
Written by Kang Moua
Revised: 12/01/2022
-->

<?PHP
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// functions
function runQuery($sql, $msg, $echoSuccess)
{
    global $conn;

    // run the query
    if ($conn->query($sql) === TRUE) {
        if ($echoSuccess) {
            echo $msg . " successful.<br />";
        }
    } else {
        echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $conn->error;
    }
}

function clearThisConsignor()
{
    global $thisConsignor;
    $thisConsignor['id_consignor'] = "";
    $thisConsignor['fName']  = "";
    $thisConsignor['lName']  = "";
    $thisConsignor['cAddress'] = "";
    $thisConsignor['cPhone'] = "";
    $thisConsignor['cDate'] = "";
}

function displayMessage($msg, $color)
{
    echo "<hr /><strong style='color:" . $color . ";'>" . $msg . "</strong><hr />";
}

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
}

function displayConsignorTable()
{
    global $conn;

    $sql = "SELECT id_consignor AS 'Person ID',
            fName AS 'First Name',
            lName AS 'Last Name',
            cAddress AS 'Address',
            CONCAT(SUBSTR(cPhone,1,3),'-',SUBSTR(cPhone,4,3),'-',SUBSTR(cPhone,7,4)) AS 'Phone',
            cDate AS 'Date',
            (SELECT COUNT(*) FROM commission WHERE calledInDate != '1970-01-01' AND checkCreatedDate = '1970-01-01' AND id_consignor = consignor.id_consignor) 
            AS 'Check Needed', 
            (SELECT COUNT(*) FROM commission WHERE pickUpDate != '1970-01-01' AND id_consignor = consignor.id_consignor) 
            AS 'Check Ready', 
            (SELECT COUNT(*) FROM item WHERE itemActive = '1' AND id_consignor = consignor.id_consignor) 
            AS 'Active Items'
            FROM consignor
            ORDER BY id_consignor";
    $result = $conn->query($sql);
    displayResult($result, $sql);
}

function formatPhone($phoneNumber)
{
    $formattedPhone = "";
    if ($phoneNumber > "") {
        $formattedPhone = substr($phoneNumber, 0, 3) . "-" . substr($phoneNumber, 3, 3) . "-" . substr($phoneNumber, 6, 4);
    }
    return $formattedPhone;
}

function unFormatPhone($phoneNumber)
{
    return preg_replace('/\D+/', '', $phoneNumber);
}

function createConnection()
{
    // Link to external file
    require_once(getcwd() . "/login.php");
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
?>