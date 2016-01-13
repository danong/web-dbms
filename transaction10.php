<!DOCTYPE html>

<html>
<head>
    <title>Merced Real Estate Management - Home</title>
    <link href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/shift.css" rel="stylesheet">
    <link rel="stylesheet" href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/bootstrap.css"/>
    <link rel="stylesheet" href="main.css" />
</head>

<body>
    <div class="nav">
        <div class="container">
            <ul class="pull-left">
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html">About</a></li>
            </ul>
            <ul class="pull-right">
                <li><a href="transaction1.html">DBMS</a></li>
                <li><a href="help.html">Help</a></li>
            </ul>
        </div>
    </div>
        <div class="jumbotron" id="jumbocon">
            <div class="container">
                <h1>Merced Rental Management Inc</h1>
                <p>Santa Clara University's premier real estate company.</p>
            </div>
        </div>
     <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" id="sidebar-wrapper">
          <ul class="nav nav-sidebar" id="sidebar-text">
            <li><h4>Properties</h4></li>
            <li><a href="transaction1.html">Properties by Branch</a></li>
            <li><a href="transaction2.html">Properties by Supervisor</a></li>
            <li><a href="transaction3.html">Properties by Owner</a></li>
            <li><a href="transaction4.html">Find a Property</a></li>
            <li><h4>Lease Agreements</h4></li>
            <li><a href="transaction5.html">Create a Lease Agreement</a></li>
            <li><a href="transaction6.html">Find a Lease Agreement</a></li>
            <li><a href="transaction7.html">Leases Ending Soon</a></li>
	    <li><h4>Statistics</h4></li>
            <li><a href="transaction8.html">List Renters with Multiple Properties</a></li>
	    <li><a href="transaction9.html">Show Number of Properties Available By Branch</a></li>
	    <li><a href="transaction10.html">Average Rent by City</a><li>
          </ul>
        </div>
        <div class="col-sm9 col-sm-offset-3 col-md10 col-md-offset-2 main" id="maincon">
            <h1 class="page-header">Average Rent by City</h1>
            <?php
            $conn=oci_connect('dong','dan0ng01', '//dbserver.engr.scu.edu/db11g');
	    $city=$_POST['city'];
            if($conn){
                echo "<h4> Displaying the average rent of both average rent for both all properties and available properties in $city</h4>";
                }
            else {
                $e = oci_error;
                print "connection failed:";
                print htmlentities($e['message']);
                exit;
            }
            
            // create SQL statement
            $sql = "SELECT avg(monthRent)
		    FROM Rental_Property
		    GROUP BY CITY
		    HAVING city='$city'";
            
            // parse SQL statement
            $sql_statement = OCIParse($conn,$sql);
            
            
            // execute SQL query
            OCIExecute($sql_statement);
            
            // get number of columns for use later
            $num_columns = OCINumCols($sql_statement);
            
            
            // start results formatting
            echo "<TABLE class = 'table table-striped'>";
            echo "<TH>Average rent for all properties</TH>";
            
            // format results by row
            while (OCIFetch($sql_statement)){
            echo "<TR>";
             for ($i = 1; $i <= $num_columns; $i++) {
                $column_value = OCIResult($sql_statement,$i);
                echo "<TD>$column_value</TD>";
             }
            echo "</TR>";
            }
            echo "</TABLE>";
            // free resources and close connection
            OCIFreeStatement($sql_statement);

            // create SQL statement
            $sql = "SELECT avg(monthRent)
		    FROM Rental_Property
		    WHERE status='available'
		    GROUP BY CITY
		    HAVING city='$city'";
            
            // parse SQL statement
            $sql_statement = OCIParse($conn,$sql);
            
            
            // execute SQL query
            OCIExecute($sql_statement);
            
            // get number of columns for use later
            $num_columns = OCINumCols($sql_statement);
            
            
            // start results formatting
            echo "<TABLE class class='table table-striped'>";
            echo "<TH>Average rent for available properties</TH>";
            
            // format results by row
            while (OCIFetch($sql_statement)){
            echo "<TR>";
             for ($i = 1; $i <= $num_columns; $i++) {
                $column_value = OCIResult($sql_statement,$i);
                echo "<TD>$column_value</TD>";
             }
            echo "</TR>";
            }
            echo "</TABLE>";
            // free resources and close connection
            OCIFreeStatement($sql_statement);
            OCILogoff($conn);
            ?>
        </div>
	<button onclick="goBack()">Back</button>

	<script>
	function goBack() {
	  window.history.back();
	}
</script>
</body>
</html>
