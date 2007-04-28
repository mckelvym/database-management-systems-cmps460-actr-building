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

Shows all office hours for all employees.
-->
<?php include("../header.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php
$query = "select o.id as id, day, time, firstname, lastname from officehours o, employee e where e.id = o.id order by lastname, firstname, day, time";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=3 align=center>All Office Hours</td></tr></thead>";	
echo "<thead class=\"default\">";
echo "<tr><td>Name</td><td>Day</td><td>Time</td></tr></thead>";	

echo "<tbody class=\"default\">";

// output all the information to a table
while($row = mysql_fetch_assoc($result)){	
	$id = $row['id'];
	$first = $row['firstname'];
	$last = $row['lastname'];
	$day = $row['day'];
	$time = $row['time'];
	echo "<tr>";
	echo "<td><a href=\"employeeinfo.php?pageid=2&id=$id\">$first $last</a></td>";
	if($day == "m"){
		echo "<td>Monday</td>";	
	}
	else if($day == "t"){
		echo "<td>Tuesday</td>";	
	}
	else if($day == "w"){
		echo "<td>Wednesday</td>";	
	}
	else if($day == "r"){
		echo "<td>Thursday</td>";	
	}
	else if($day == "f"){
		echo "<td>Friday</td>";	
	}
	else if($day == "s"){
		echo "<td>Saturday</td>";	
	}
	else if($day == "u"){
		echo "<td>Sunday</td>";	
	}
	echo "<td>$time</td>";
	echo "</tr>";
}
echo "</td></tbody></table>";
mysql_free_result($result);

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
