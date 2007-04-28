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

Allows editing of an employee's teaching duties.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php

$id = (string)$_GET['id'];
$mode = (string)$_GET['mode'];

if($mode == ""){ $mode = "show"; }
$redirect="employeeinfo.php?id=$id";        // redirect to page

// pops up a javascript message box
function popup($msg){
	echo "<script language=\"javascript\">\n alert(\"".$msg."\"); \n </script>";	
}

// returns a hyperlink to a javascript popup message
function popuplink($msg,$linktext){
	return "<a href=\"javascript:alert('$msg')\">$linktext</a>";
}

// pops up a javascript message box and then redirects to another page
function redirect($msg, $location){
	echo "<script language=\"javascript\">\n alert(\"".$msg."\"); \n window.location = \"".$location."\"; \n</script>";	
}

// delete teaching duties
if($mode == "del"){
	$cid = (string)$_GET['cid'];
	$query = "delete from class where course_id = '$cid'";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Deleted selected class.", "teaching_edit.php?id=$id&mode=show");	
}

// delete all teaching duties and associated classes
else if($mode == "delall"){
	$query = "delete from class where teacher_id = '$id'";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Deleted all classes that the employee teaches.", $redirect);
}
// show all teaching duties
else if($mode == "show"){
	$query = "select firstname,lastname from employee where id = '$id'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	$fn = $row['firstname'];
	$ln = $row['lastname'];
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td align=center>Manage Classes<br/>$fn $ln</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	echo "<tr><td align=center><a href=\"teaching_edit.php?id=$id&mode=delall\">Delete All</a></td></tr>";
	echo "</tbody>";
	echo "</table>";

	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td>Course #</td><td>Room</td><td>Days</td><td>Time</td><td>Term</td><td>Year</td><td>Manage</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	$query = "select room_num,days,time,term,year,course_num,course_id from employee e,class c where e.id = '$id' and e.id = c.teacher_id order by year,term,room_num";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

	if(mysql_num_rows($result) == 0){
		echo "<tr><td colspan=7>None</td></tr>";
	}

	while($row = mysql_fetch_assoc($result)){
		$room = $row['room_num'];
		$days = strtoupper($row['days']);
		$time = $row['time'];
		$term = $row['term'];
		$year = $row['year'];
		$course_num = $row['course_num'];
		$course_id = $row['course_id'];
		echo "<tr><td>CMPS $course_num</td><td>$room</td><td>$days</td><td>$time</td><td>$term</td><td>$year</td><td><a href=\"teaching_edit.php?id=$id&mode=del&cid=$course_id\">Delete</a></td></tr>";
	}
	mysql_free_result($result);
	echo "</tbody>";
	echo "</table>";
	
}
else{
	redirect("ERROR: BAD GET INFO!", $redirect);
}

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
