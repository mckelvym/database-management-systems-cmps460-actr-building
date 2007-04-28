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

Shows all classes available.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php

// big query to just get all the information and show in tabular style
$query = "select year,term,course_num,course_id,section,days,time,level,teacher_id,room_num,firstname,lastname from class c, employee e where c.teacher_id = e.id order by year,term,course_num,section,days,level";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=10 align=center>All Classes</td></tr></thead>";	
echo "<thead class=\"default\">";
echo "<tr><td>Year</td><td>Term</td><td>Course #</td><td>Course ID</td><td>Section</td><td>Days</td><td>Time</td><td>Level</td><td>Teacher</td><td>Room</td></tr></thead>";	

echo "<tbody class=\"default\">";

// fetch everything from the query and show it
while($row = mysql_fetch_assoc($result)){	
	$id = $row['teacher_id'];
	$last = $row['lastname'];
	$first = $row['firstname'];
	$year = $row['year'];
	$term = $row['term'];
	$course_num = $row['course_num'];
	$course_id = $row['course_id'];
	$section = $row['section'];
	$days = strtoupper($row['days']);
	$time = $row['time'];
	$level = $row['level'];
	$room = $row['room_num'];
	echo "<tr>";
	echo "<td>$year</td>";
	echo "<td>$term</td>";
	echo "<td>$course_num</td>";
	echo "<td>$course_id</td>";
	echo "<td>$section</td>";
	echo "<td>$days</td>";
	echo "<td>$time</td>";
	echo "<td>$level</td>";
	echo "<td><a href=\"employeeinfo.php?id=$id\">$first $last</a></td>";
	echo "<td><a href=\"room.php\">$room</a></td>";
	echo "</tr>";
}
echo "</td></tbody></table>";
mysql_free_result($result);

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
