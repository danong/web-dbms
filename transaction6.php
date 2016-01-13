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
            <h1 class="page-header">View Lease Agreement</h1>
            <?php
            $conn=oci_connect('dong','dan0ng01', '//dbserver.engr.scu.edu/db11g');
	    $rentalNo = $_POST['rentalNo'];
            if($conn){
                echo "<h4> Lease Agreement for Rental Number: $rentalNo</h4>";
                }
            else {
                $e = oci_error;
                print "connection failed:";
                print htmlentities($e['message']);
                exit;
            }
            
            // create SQL statement
            $sql = "SELECT name AS NAME, homeNo AS HOMENO, workNo AS WORKNO, startDate AS STARTDATE, endDate AS ENDDATE, rentAmount AS RENTAMOUNT, street AS STREET, city as CITY
                    FROM Lease_Agreement natural join Renter natural join Rental_Property
		    WHERE rentalNo = '$rentalNo'";
            
            // parse SQL statement
            $sql_statement = OCIParse($conn,$sql);
            
	    // save results to PHP variables
            OCI_DEFINE_BY_NAME($sql_statement, 'NAME', $name);
            OCI_DEFINE_BY_NAME($sql_statement, 'HOMENO', $home_no);
            OCI_DEFINE_BY_NAME($sql_statement, 'WORKNO', $work_no);
            OCI_DEFINE_BY_NAME($sql_statement, 'STARTDATE', $start_date);
            OCI_DEFINE_BY_NAME($sql_statement, 'ENDDATE', $end_date);
            OCI_DEFINE_BY_NAME($sql_statement, 'RENTAMOUNT', $rent_amount);
            OCI_DEFINE_BY_NAME($sql_statement, 'STREET', $street);
            OCI_DEFINE_BY_NAME($sql_statement, 'CITY', $city);

            // execute SQL query
            OCIExecute($sql_statement);
	    OCI_FETCH($sql_statement);

	    // display lease agreement
	    echo "<p>This Rental Agreement or Residential Lease shall evidence the complete terms and conditions under which the parties whose signatures appear below have agreed. 
		  As consideration for this agreement, Merced Inc agrees to rent to $name the premises located at $street in the city of $city</p>";

	    echo "<p><h4>1. TERMS:</h4> $name agrees to pay $rent_amount USD per month. This agreement shall commence on $start_date and continue until $end_date. 
		  If $name should move from the premises prior to the expiration of this time period, he shall be liable for all rent due until such time
		  that the Residence is occupied by a Merced Inc approved paying RESIDENT and/or expiration of said time period,
		  whichever is shorter.</p>";

	    echo "<p><h4>2. DEPOSIT</h4> $name agrees to pay a $rent_amount USD security deposit. The total of the above deposits shall secure compliance with the terms and conditions of
		  this agreement and shall be refunded to $name within 30 days after the premises have been completely 
		  vacated less any amount necessary to pay Merced; a) any unpaid rent, b) cleaning costs, c) key replacement costs, d) 
		  cost for repair of damages to premises and/or common areas above ordinary wear and tear, and e) any other amount 
		  legally allowable under the terms of this agreement.</p>";

	    echo "<p><br> $name's Signature ___________________________________________________
		  <br><br>Date__________________
		  <br><br> Agent's Signature ____________________________________________ 
		  <br><br>Date__________________</p>";
            // get number of columns for use later
            $num_columns = OCINumCols($sql_statement);
            
            
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
