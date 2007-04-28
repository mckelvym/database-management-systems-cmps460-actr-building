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

$post_info = (string)$_GET['id'];
if($post_info == ""){
	echo "ERROR: NO GET INFO!";
}

$query = "select * from employee e where e.id = '$post_info'";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

$row = mysql_fetch_assoc($result);
$id = $row['id'];
$last = $row['lastname'];
$first = $row['firstname'];
$office = $row['office_num'];
$phone = $row['phone'];
$photo = $row['photo'];
$website = $row['website'];
$pos = $row['position'];

echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=2>Employee Management</td></tr></thead>";	
echo "<tbody class=\"default\">";
if($pos == "faculty"){
	echo "<tr><td><a href=\"employee_edit.php?id=$id&mode=del\">Delete</a></td><td><a href=\"employee_edit.php?id=$id&mode=edit\">Edit</a></tr><tr><td><a href=\"officehours_edit.php?id=$id\">Officehours Edit</td><td><a href=\"teaching_edit.php?id=$id\">Teaching Duties Edit</a></td></tr>\n";
}
else{
	echo "<tr><td><a href=\"employee_edit.php?id=$id&mode=del\">Delete</a></td><td><a href=\"employee_edit.php?id=$id&mode=edit\">Edit</a></tr><tr><td colspan=2><a href=\"officehours_edit.php?id=$id\">Edit Officehours</td></tr>\n";
}
echo "</tbody></table>";

echo "<br/>";

echo "<table class=\"default\">";
if($photo != ""){
	echo "<tr><td><img src=\"../$photo\" width=250>"."</td></tr>\n";
}
echo "</table>";
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=2>Employee Information</td></tr></thead>";	
echo "<tbody class=\"default\">";
echo "<tr><td>Name: </td><td>${last}, $first"."</td></tr>\n";
echo "<tr><td>ID: </td><td>$id"."</td></tr>\n";
echo "<tr><td>Office #: </td><td>$office"."</td></tr>\n";
echo "<tr><td>Phone #: </td><td>$phone"."</td></tr>\n";
echo "<tr><td>Website: </td><td><a href=\"$website\">$website</a>"."</td></tr>\n";
echo "<tr><td>Position: </td><td>".ucwords($pos)."</td></tr>\n";
echo "<tr><td colspan=2 align=center>Office Hours</td></tr>\n";
$query = "select * from employee e,officehours o where e.id = '$post_info' and e.id = o.id order by o.day";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
$row = mysql_fetch_assoc($result);

if(mysql_num_rows($result) == 0){
	echo "<tr><td colspan=2>None</td></tr>";
}

$mon="";
$tue="";
$wed="";
$thu="";
$fri="";
$sat="";
$sun="";

$i = 0;
while($i < mysql_num_rows($result)){
	$day = $row['day'];
	$time = $row['time'];
	$row = mysql_fetch_assoc($result);	
	if($day == "m"){
		$mon=$mon.$time."<br/>";
	}
	else if($day == "t"){
		$tue=$tue.$time."<br/>";
	}
	else if($day == "w"){
		$wed=$wed.$time."<br/>";
	}
	else if($day == "r"){
		$thu=$thu.$time."<br/>";
	}
	else if($day == "f"){
		$fri=$fri.$time."<br/>";
	}
	else if($day == "s"){
		$sat=$sat.$time."<br/>";
	}
	else if($day == "u"){
		$sun=$sun.$time."<br/>";
	}	
	$i= $i + 1;	
}

if($mon != ""){
	echo "<tr><td>Monday</td><td>$mon</td></tr>\n";
}
if($tue != ""){
	echo "<tr><td>Tuesday</td><td>$tue</td></tr>\n";
}
if($wed != ""){
	echo "<tr><td>Wednesday</td><td>$wed</td></tr>\n";
}
if($thu != ""){
	echo "<tr><td>Thursday</td><td>$thu</td></tr>\n";
}
if($fri != ""){
	echo "<tr><td>Friday</td><td>$fri</td></tr>\n";
}
if($sat != ""){
	echo "<tr><td>Saturday</td><td>$sat</td></tr>\n";
}
if($sun != ""){
	echo "<tr><td>Sunday</td><td>$sun</td></tr>\n";
}
echo "</tbody></table>";

echo "<br/>";

$query2 = "select room_num as Room,days as Days,time as Time,term as Semester,year as Year from employee e,class c where e.id = '$post_info' and e.id = c.teacher_id order by year,term,room_num";
$result2 = mysql_query((string)$query2) or die('BAD QUERY '.mysql_error());

if(mysql_num_rows($result2) != 0){
	echo "<table class=\"default\">";
	echo "<thead class=\"default\">";
	echo "<tr><td colspan=5>Teaching Schedule</td></tr></thead>";	
	echo "<thead class=\"default\"><tr>";
	for ($i=0; $i < mysql_num_fields($result2); $i++){
		$field_name = mysql_field_name($result2, $i);
		echo "<td>$field_name</td>";
	}
	echo "</tr></thead>";

	echo "<tbody class=\"default\">";

	$i = 0;
	while($i < mysql_num_rows($result2)){
		$row = mysql_fetch_assoc($result2);		
		$room = $row['Room'];
		$days = $row['Days'];
		$time = $row['Time'];
		$term = $row['Semester'];
		$year = $row['Year'];
		
		echo "<tr><td>$room</td><td>".strtoupper($days)."</td><td>$time</td><td>$term</td><td>$year</td></tr>\n";
		$i = $i + 1;
	}
	echo "</tbody></table>";
}

mysql_free_result($result2);
mysql_free_result($result);

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
