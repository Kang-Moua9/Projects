<!--
createDatabase.php - creates a dynamic database and displays it
Written by Kang Moua
Revised: 12/01/2022
-->

<?PHP 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?PHP

// Link to external file
require_once(getcwd() . "/function.php");

createConnection();

// Is this a return visit?
if (array_key_exists('hidIsReturning', $_POST)) {

    // Get the array that was stored as a session variable
    // Used to populate the HTML text boxes using JavaScript DOM
    $thisConsignor = unserialize(urldecode($_SESSION['sessionThisConsignor']));

    // Did the user select a consignor from the list?
    // 'new' is the value of the first item on the consignor list box 
    if (isset($_POST['lstConsignor']) && !($_POST['lstConsignor'] == 'new')) {

        $id_consignor = $_POST['lstConsignor'];

        $sql = "SELECT id_consignor, fName, lName, cAddress, cPhone, cDate FROM consignor WHERE id_consignor=?";

        // Set up a prepared statement
        if ($stmt = $conn->prepare($sql)) {
            // Pass the parameters
            $stmt->bind_param("i", $id_consignor);
            if ($stmt->errno) {
                displayMessage("stmt prepare( ) had error.", "red");
            }

            // Execute the query
            $stmt->execute();
            if ($stmt->errno) {
                displayMessage("Could not execute prepared statement", "red");
            }

            // Optional - Download all the rows into a cache
            // When fetch( ) is called all the records will be downloaded
            $stmt->store_result();

            // Get number of rows 
            //(only good if store_result( ) is used first)
            $rowCount = $stmt->num_rows;

            // Bind result variables
            // one variable for each field in the SELECT
            // This is the variable that fetch( ) will use to store the result
            $stmt->bind_result($id_consignor, $fName, $lName, $cAddress, $cPhone, $cDate);

            // Fetch the value - returns the next row in the result set
            $stmt->fetch();

            // Free results
            $stmt->free_result();

            // Close the statement
            $stmt->close();
        } // end if($stmt = $conn->prepare($sql))

        // Create an associative array
        $thisConsignor = [
            "id_consignor" => $id_consignor,
            "fName" => $fName,
            "lName" => $lName,
            "cAddress" => $cAddress,
            "cPhone" => $cPhone,
            "cDate" => $cDate
        ];

        // Save array as a serialized session variable
        $_SESSION['sessionThisConsignor'] = urlencode(serialize($thisConsignor));
    } // end if lstConsignor        

    // Determine which button may have been clicked
    switch ($_POST['btnSubmit']) {
            // = = = = = = = = = = = = = = = = = = = 
            // DELETE  
            // = = = = = = = = = = = = = = = = = = = 
        case 'delete':
            //displayMessage("DEBUG DELETE button pushed.", "green");

            //Make sure a consignor has been selected.
            if ($_POST["txtFName"] == "") {
                displayMessage("Please select a consignor's name.", "red");
            } else {

                $sql = "DELETE FROM consignor WHERE id_consignor = ?";
                // Prepare
                if ($stmt = $conn->prepare($sql)) {
                    // Bind the parameters
                    $stmt->bind_param("i", $thisConsignor['id_consignor']);
                    if ($stmt->errno) {
                        displayMessage("stmt prepare( ) had error.", "red");
                    }
                    // Execute the query
                    $stmt->execute();
                    if ($stmt->errno) {
                        displayMessage("Could not execute prepared statement", "red");
                    }
                    // Free results
                    $stmt->free_result();
                    // Close the statement
                    $stmt->close();
                } // end if( prepare( ))
            } // end of if
            // Zero out the current selected consignor
            clearThisConsignor();
            break;
            // = = = = = = = = = = = = = = = = = = = 
            // ADD NEW CONSIGNOR 
            // = = = = = = = = = = = = = = = = = = = 
        case 'new':
            //displayMessage("ADD button pushed.", "green");
            // Check for duplicate names using fName and lName
            // Hard-coded SQL test

            $sql = "SELECT COUNT(*) AS total FROM consignor 
                WHERE fName='" . $_POST['txtFName'] . "'
                AND   lName='" . $_POST['txtLName'] . "'";

            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            // consignor already registered?
            if ($row['total'] > 0) {
                displayMessage("This consignor is already registered.", "red");
            }
            //No duplicates
            else {
                // Check for empty name fields or phone 
                if (
                    $_POST['txtFName'] == ""
                    || $_POST['txtFName'] == ""
                    || $_POST['txtCPhone'] == ""
                ) {
                    displayMessage("Please type in the correct inputs.", "red");
                }
                // First name and last name are populated
                else {
                    $sql = "INSERT INTO consignor (id_consignor, fName, lName, cAddress, cPhone, cDate) VALUES (NULL, ?,?,?,?,?)";
                    // Set up a prepared statement
                    if ($stmt = $conn->prepare($sql)) {
                        // Set up parameters
                        $fName =$_POST['txtFName'];
                        $lName = $_POST['txtLName'];
                        $cAddress = $_POST['txtCAddress'];
                        $cPhone = $_POST['txtCPhone'];
                        $cDate = $_POST['txtCDate'];
                        // Pass the parameters
                        $stmt->bind_param("sssss", $fName, $lName, $cAddress, $cPhone, $cDate);
                        if ($stmt->errno) {
                            displayMessage("stmt prepare( ) had error.", "red");
                        }

                        // Execute the query
                        $stmt->execute();
                        if ($stmt->errno) {
                            displayMessage("Could not execute prepared statement", "red");
                        }

                        $stmt->store_result();
                        $totalCount = $stmt->num_rows;

                        // Free results
                        $stmt->free_result();
                        // Close the statement
                        $stmt->close();
                    } // end if( prepare( ))
                }
            } // end of if/else empty name phone fields
            // Zero out the current selected consignor
            clearThisConsignor();
            // end of if/else($total > 0)
            break;
            // = = = = = = = = = = = = = = = = = = = 
            // UPDATE   
            // = = = = = = = = = = = = = = = = = = = 
        case 'update':
            //displayMessage("UPDATE button pushed.", "green");
            // Check for empty name 
            if ($_POST['txtFName'] == "" || $_POST['txtLName'] == "") {
                displayMessage("Please select a consignor name.", "red");
            }
            else {
                $sql = "UPDATE consignor SET fName=?, lName=?, cAddress=?, cPhone=?, cDate=? WHERE id_consignor=?";
                // Set up a prepared statement
                if ($stmt = $conn->prepare($sql)) {
                    // Set up parameters
                    $fName =$_POST['txtFName'];
                    $lName = $_POST['txtLName'];
                    $cAddress = $_POST['txtCAddress'];
                    $cPhone = unformatPhone($_POST['txtCPhone']);
                    $cDate = $_POST['txtCDate'];
                    $id_consignor = $thisConsignor['id_consignor'];
                    // Pass the parameters
                    $stmt->bind_param("sssssi", $fName, $lName, $cAddress, $cPhone, $cDate, $id_consignor);
                    if ($stmt->errno) {
                        displayMessage("stmt prepare( ) had error.", "red");
                    }

                    // Execute the query
                    $stmt->execute();
                    if ($stmt->errno) {
                        displayMessage("Could not execute prepared statement", "red");
                    }

                    $stmt->store_result();
                    $totalCount = $stmt->num_rows;

                    // Free results
                    $stmt->free_result();
                    // Close the statement
                    $stmt->close();
                } // end if( prepare( ))
            }
            // Zero out the current selected consignor
            clearThisConsignor();
            break;

        case 'sample':
                // Link to database file
                require_once(getcwd() . "/createDb.php");
                // Link to external file
                require_once(getcwd() . "/sampleData.php");
            break;

    } // end of switch( )

}

?>

<body>
    <header>
        <h1><a href='index.html' id="title">Secret Sister Boutique</a></h1>
    </header>
    <div class='main'>
        <a id='navi' class='navi' href='createDatabase.php'>Consignor</a>
        <a id='navi' class='navi' href=''>Order</a>
        <a id='navi' class='navi' href=''>Item</a>
    </div>
    <div id="frame">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name="frmRegistration"
            id="frmRegistration">

            <label for="lstConsignor"><strong>Select A Consignor Name</strong></label>

            <select name="lstConsignor" id="lstConsignor" onChange="this.form.submit();">
                <option value="new">Select a name</option>
                <?PHP
                // Loop through the consignor table to build the <option> list
                $sql = "SELECT id_consignor, CONCAT(fName,' ',lName) AS 'name' 
                FROM consignor ORDER BY fName";
                $result = $conn->query($sql);

                /*
                // Close out existing connection
                // Create a new one for the stored procedure
                mysqli_close($conn);
                createConnection();
                // Set up the SQL String, calling a stored procedure
                $sql = 'call getConsignorList()';
                // Run the stored procedure
                $result = $conn->query($sql);
                */

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_consignor'] . "'>" . $row['name'] . "</option>\n";
                }

                /*
                // Close the stored procedure connection and reopen a new one
                // for other SQL calls
                mysqli_close($conn);
                createConnection();
                */

                ?>
            </select>
            &nbsp;&nbsp;<a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">New</a>

            <button name="btnSubmit" id="sampleButton" value="sample"  onclick="this.form.submit();">
                Restart and Input Sample Data
            </button>

            <h3>Consignor Information</h3>

            <fieldset>
                <div class="topLabel">
                    <label for="txtFName">First Name</label>
                    <input type="text" name="txtFName" id="txtFName" value="<?php echo $thisConsignor['fName']; ?>" />

                </div>
                <div class="topLabel">
                    <label for="txtLName">Last Name</label>
                    <input type="text" name="txtLName" id="txtLName" value="<?php echo $thisConsignor['lName']; ?>" />
                </div>
                <div class="topLabel">
                    <label for="txtCAddress">Address</label>
                    <input type="text" name="txtCAddress" id="txtCAddress"
                        value="<?php echo $thisConsignor['cAddress']; ?>" />
                </div>
                <div class="topLabel">
                    <label for="txtCPhone">Phone</label>
                    <input type="text" name="txtCPhone" id="txtCPhone"
                        value="<?php echo formatPhone($thisConsignor['cPhone']); ?>" />
                </div>
                <div class="topLabel">
                    <label for="txtCDate">Date</label>
                    <input type="text" name="txtCDate" id="txtCDate" value="<?php echo $thisConsignor['cDate']; ?>" />
                </div>
            </fieldset><br />

            <button name="btnSubmit" id="deleteButton" value="delete" style="float:left;" onclick="this.form.submit();">
                Delete
            </button>

            <button name="btnSubmit" id="addButton" value="new" style="float:left;" onclick="this.form.submit();">
                Add New Consignor
            </button>

            <button name="btnSubmit" id="updateButton" value="update" style="float:left;" onclick="this.form.submit();">
                Update
            </button><br />

            <!-- Use a hidden field to tell server if return visitor -->
            <input type="hidden" name="hidIsReturning" value="true" />
        </form><br /><br />

        <h2>Consignment Table</h2>

        <div class="consignorTable">
            <?PHP
            displayConsignorTable();
            echo "<br />";
            $conn->close();
            ?>
        </div>

        <script>
        // Update the values of the list boxes based on the current selection 
        document.getElementById("lstConsignor").value = "<?PHP echo $thisConsignor['id_consignor']; ?>";
        </script>

    </div>
</body>

</html>
