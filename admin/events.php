<?php
/*
Authors:
James McKelvy (jmm0468)
Gavin Choate (gdc0730)
Jed Ancona (jca8822)

CMPS460
Database Project
April 27, 2007

~~~ CERTIFICATION OF AUTHENTICITY ~~~
The code contained within this script is the combined work of the above mentioned authors.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php
$query = "select e.location as location, e.date as date,e.time as time,e.contact_id as id,e.purpose as purpose,em.firstname as first, em.lastname as last from events e, employee em where em.id = e.contact_id order by e.date,e.time,e.location,e.contact_id";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=3>Event Management</td></tr></thead>";	
echo "<tbody class=\"default\">";
echo "<tr><td><a href=\"event_edit.php?mode=delall\">Delete All</a></td><td><a href=\"event_edit.php?mode=add\">Add</a></tr>\n";
echo "</tbody></table>";

echo "<br/>";

echo "<table class=\"default\">";
echo "<thead class=\"default\"><tr>";
echo "<td colspan=7 align=center>Schedule of Events</td>";
echo "<thead class=\"default\"><tr>";
echo "<td>Date</td><td>Time</td><td>Contact</td><td>Location</td><td>Purpose</td><td colspan=2 align=center>Manage</td>";
echo "</tr></thead>";
echo "<tbody class=\"default\">";


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
	echo "<td><a href=\"employeeinfo.php?id=$id\">$first $last</a></td>";	
	echo "<td>$location</td>";
	echo "<td>$purpose</td>";
	echo "<td><a href=\"event_edit.php?mode=edit&d=$date&t=$time&l=$location\">Edit</a></td>";
	echo "<td><a href=\"event_edit.php?mode=del&d=$date&t=$time&l=$location\">Delete</a></td>";
	echo "</tr>";
}
echo "</tbody></table>";
mysql_free_result($result);

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
