<!DOCTYPE HTML PUBLIC
"-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Result</title>
</head>
<body>

<?php

  function showerror() {
     die("Error " . mysql_errno() . " : " . mysql_error());
  }

  require 'db.php';

  // Show all wines in a region in a <table>
  function displayWinesList($connection, $query, $regionName) {
    // Run the query on the server
    if (!($result = @ mysql_query ($query, $connection))) {
      showerror();
    }

    // Find out how many rows are available
    $rowsFound = @ mysql_num_rows($result);

    // If the query has results ...
    if ($rowsFound > 0) {
      // ... print out a header
      print "Wines of $regionName<br>";

      	// and start a <table>.
      	print "\n<table>\n<tr>" .
          	"\n\t<th>Wine Name</th>" .
		"\n\t<th>Grape Variety</th>" .
          	"\n\t<th>Year</th>" .
          	"\n\t<th>Winery</th>" .
		"\n\t<th>Region</th>" .
		"\n\t<th>Cost in Inventory</th>" .
		"\n\t<th>Total Available Bottles</th>" .
		"\n\t<th>Total Stock Sold</th>" .
          	"\n\t<th>Total Sales Revenue</th>\n</tr>";

      // Fetch each of the query rows
      while ($row = @ mysql_fetch_array($result)) {
        // Print one row of results
        print 	"\n<tr>\n\t<td>{$row["wine_id"]}</td>" .
            	"\n\t<td>{$row["variety"]}</td>" .
            	"\n\t<td>{$row["year"]}</td>" .
            	"\n\t<td>{$row["winery_name"]}</td>" .
		"\n\t<td>{$row["region_name"]}</td>" .
		"\n\t<td>{$row["cost"]}</td>" .
		"\n\t<td>{$row["on_hand"]}</td>" .
		"\n\t<td>{$row["total_sold"]}</td>" .
            	"\n\t<td>{$row["total_revenue"]}</td>\n</tr>";
      } // end while loop body

      // Finish the <table>
      print "\n</table>";
    } // end if $rowsFound body
	else
	{
		print "No records found matching your criteria<br/>";
	}
    // Report how many rows were found
    print "{$rowsFound} records found matching your criteria<br>";
  } // end of function

  // Connect to the MySQL server
  if (!($connection = @ mysql_connect(DB_HOST, DB_USER, DB_PW))) {
    die("Could not connect");
  }

  // get the user data
  $wineName = $_GET['wineName'];
  $wineryName = $_GET['wineryName'];
  $regionName = $_GET['regionName'];
  $grapeVariety = $_GET['grapeVariety'];
  $lowYear = $_GET['lowYear'];
  $upYear = $_GET['upYear'];
  $minStock = $_GET['minStock'];
  $minOrdered = $_GET['minOrdered'];
  $minCost = $_GET['minCost'];
  $maxCost = $_GET['maxCost'];  

  if (!mysql_select_db(DB_NAME, $connection)) {
    showerror();
  }

  // Start a query ...
  $query = "SELECT wine_id, wine_name, description, year, winery_name
FROM winery, region, wine
WHERE winery.region_id = region.region_id
AND wine.winery_id = winery.winery_id";

  // ... then, if the user has specified a region, add the regionName
  // as an AND clause ...
  if (isset($regionName) && $regionName != "All") {
    $query .= " AND region_name = '{$regionName}'";
  }

  if (isset($wineName)) {
    $query .= " AND region_name = '{$regionName}'";
  }

  if (isset($wineryName)) {
    $query .= " AND region_name = '{$regionName}'";
  }

  if (isset($grapeVariety)) {
    $query .= " AND region_name = '{$regionName}'";
  }

  if (isset($lowYear) && isset($upYear)) {
    $query .= " AND region_name = '{$regionName}'";
  }

  if (isset($minStock)) {
    $query .= " AND region_name = '{$regionName}'";
  }

  if (isset($minOrdered)) {
    $query .= " AND region_name = '{$regionName}'";
  }

  if (isset($minCost) && isset($maxCost)) {
    $query .= " AND region_name = '{$regionName}'";
  }

  // ... and then complete the query.
  $query .= " ORDER BY wine_name";

  // run the query and show the results
  displayWinesList($connection, $query, $regionName);
?>
</body>
</html>
