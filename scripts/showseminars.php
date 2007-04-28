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

Shows all seminars.
-->
<?php include("../header.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php
$query = "select room_num, contact_id, date, time, purpose, firstname, lastname from seminar s, employee e where s.contact_id = e.id order by date, time, room_num, lastname, firstname";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=5 align=center>All Seminars</td></tr></thead>";	
echo "<thead class=\"default\">";
echo "<tr><td>Room</td><td>Contact</td><td>Date</td><td>Time</td><td>Purpose</td></tr></thead>";	

echo "<tbody class=\"default\">";

// output all seminars to a table.
while($row = mysql_fetch_assoc($result)){	
	$id = $row['contact_id'];
	$last = $row['lastname'];
	$first = $row['firstname'];
	$date = $row['date'];
	$time = $row['time'];
	$room = $row['room_num'];
	$purpose = $row['purpose'];
	
	$tmp = mysql_query("select room_type from room where room_num = '$room'") or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($tmp);
	mysql_free_result($tmp);
	echo "<tr>";
	echo "<td><a href=\"roominfo.php?pageid=3&room=$room&type=".$row['room_type']."\">$room</a></td>";
	echo "<td><a href=\"employeeinfo.php?pageid=2&id=$id\">$first $last</a></td>";
	echo "<td>$date</td>";
	echo "<td>$time</td>";
	echo "<td>$purpose</td>";
	echo "</tr>";
}
echo "</td></tbody></table>";
mysql_free_result($result);

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
