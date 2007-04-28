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
//Displays the classes with the admin options to add, update and delete, delete all options
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php

$mode_info = (string)$_GET['mode'];

$query = "select distinct term,year from class order by year,term";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

//add and delete options
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=3>Class Management</td></tr></thead>";	
echo "<tbody class=\"default\">";
echo "<tr><td><a href=\"class_edit.php?mode=delall\">Delete All</a></td><td><a href=\"class_edit.php?mode=add\">Add</a></tr>\n";
echo "</tbody></table>";
echo "<br/>";


echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=1 align=center>Term</td></tr></thead>";
echo "<tbody class=\"default\">";
echo "<tr><td>";	
echo "<form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";

$g_term = $_GET['term'];
$g_year = $_GET['year'];
if($g_term != "" && $g_year != ""){
	echo "<option value=\"classschedule.php?mode=classes&term=$g_term&year=$g_year\" >".$_GET['term']." ".$_GET['year']."</option>";
}
else{
	echo "<option value=\"#\" >Select Term</option>";
}


while($row = mysql_fetch_assoc($result)){
		
	$term=$row['term'];
        $year=$row['year'];
	if($term == "SU"){
	    echo "<option value=\"classschedule.php?mode=classes&term=$term&year=$year\">Summer $year</option>\n";
	}
	else if($term == "FA"){
	    echo "<option value=\"classschedule.php?mode=classes&term=$term&year=$year\">Fall $year</option>\n";
	}
	else if($term == "SP"){
	    echo "<option value=\"classschedule.php?mode=classes&term=$term&year=$year\">Spring $year</option>\n";
	}
	else {
	    echo "<option value=\"classschedule.php?mode=classes&term=$term&year=$year\">Winter $year</option>\n";
	}
	
}


echo "</select></form>";
echo "</td></tr></tbody></table>";
echo "<br>";
mysql_free_result($result);

if( $mode_info == "classes"){

$year_info = (string)$_GET['year'];
$term_info = (string)$_GET['term'];
$query = "select distinct course_num from class where year = '$year_info' and term = '$term_info'";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=1 align=center>Course Number</td></tr></thead>";
echo "<tbody class=\"default\">";
echo "<tr><td>";
echo "<form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";

$g_course = $_GET['course'];
if($g_course != ""){
	echo "<option value=\"classschedule.php?mode=classes&term=$g_term&year=$g_year&course=$g_course\" >CMPS $g_course </option>\n";
}
else{
	echo "<option value=\"#\" >Select Course </option>\n";
}

while($row = mysql_fetch_assoc($result)){
		
	$course_num=$row['course_num'];
        
	    echo "<option value=\"classschedule.php?mode=classes&term=$term_info&year=$year_info&course=$course_num\">CMPS $course_num</option>\n";
	
	
}


echo "</select></form>\n";
echo "</td></tr></tbody></table>\n";
mysql_free_result($result);
echo "<br>";

}
$class_info = (string)$_GET['course'];

//displays classes of specified term with edit and delete options
if( $class_info != ""){

$year_info = (string)$_GET['year'];
$term_info = (string)$_GET['term'];
$query = "select * from class as c, course as cr,employee as e where c.year = '$year_info' and c.term = '$term_info' and c.course_num = '$class_info' and c.course_num = cr.course_num
and c.teacher_id = e.id";

$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

echo "<table class=\"schedule\">\n";

echo "<thead class=\"schedule\"><tr><td>Class</td><td>Course ID</td><td>Section</td><td>Title</td><td>Credit</td><td>Room</td><td>Days</td><td>Time</td><td>Instructor</td><td colspan=2 align=center>Manage</td></tr></thead>\n";
echo "<tbody class=\"schedule\">\n";


while($row = mysql_fetch_assoc($result)){		
	$course_id = $row['course_id'];
        $sec_id = $row['section'];
	$title = $row['title'];
	$credit = $row['credit'];
	$fName = $row['firstname'];
	$lName = $row['lastname'];
	$room = $row['room_num'];
	$days = strtoupper($row['days']);
	$time = $row['time'];
	$courseNum = $row['course_num'];
	$id = $row['id'];
	echo "<tr><td>CMPS $courseNum</td><td>$course_id</td><td>$sec_id</td><td>$title</td><td>$credit</td><td>$room</td><td>$days</td><td>$time</td><td><a href=employeeinfo.php?id=$id>$lName, $fName</a></td>";
	echo "<td><a href=\"class_edit.php?mode=edit&cid=$course_id\">Edit</a></td>";
	echo "<td><a href=\"class_edit.php?mode=del&cid=$course_id\">Delete</a></td>";
	echo "</tr>\n";	
}

echo "</tbody></table>\n";
mysql_free_result($result);


}
?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
