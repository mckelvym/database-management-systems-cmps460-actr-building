<!-- 
Authors:
James McKelvy (jmm0468)
Gavin Choate (gdc0730)
Jed Ancona (jca8822)

CMPS460
Database Project
April 27, 2007

~~~ CERTIFICATION OF AUTHENTICITY ~~~
The code contained within this script is the combined work of the above mentioned authors.

Displays all events and their information.
-->
<?php include("../header.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php
// grab all events and related information
$query = "select e.location as location, e.date as date,e.time as time,e.contact_id as id,e.purpose as purpose,em.firstname as first, em.lastname as last from events e, employee em where em.id = e.contact_id order by e.date,e.time,e.location,e.contact_id";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
echo "<table class=\"default\">";
echo "<thead class=\"default\"><tr>";
echo "<td colspan=5 align=center>Schedule of Events</td>";
echo "<thead class=\"default\"><tr>";
echo "<td>Date</td><td>Time</td><td>Contact</td><td>Location</td><td>Purpose</td>";
echo "</tr></thead>";
echo "<tbody class=\"default\">";

// show it in a table
while($row = mysql_fetch_assoc($result)){
	$id = $row['id'];
	$date = $row['date'];
	$time = $row['time'];
	$location = $row['location'];
	$purpose = $row['purpose'];
	$first = $row['first'];
	$last = $row['last'];
	echo "<tr>";
	echo "<td>$date</td>";
	echo "<td>$time</td>";
	echo "<td><a href=\"employeeinfo.php?pageid=2&id=$id\">$first $last</a></td>";	
	echo "<td>$location</td>";
	echo "<td>$purpose</td>";
	echo "</tr>";
}
echo "</tbody></table>";
mysql_free_result($result);

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
