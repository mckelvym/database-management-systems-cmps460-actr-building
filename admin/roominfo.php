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

This script shows information about a specific room, be it an office, classroom, etc.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php

$post_info = (string)$_GET['room'];
$post_type = (string)$_GET['type'];
if($post_info == ""){
	echo "ERROR: NO GET INFO!";
}

// begin table
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=2>Room Management</td></tr></thead>";	
echo "<tbody class=\"default\">";
echo "<tr><td><a href=\"room_edit.php?room=$post_info&mode=del\">Delete</a></td><td><a href=\"room_edit.php?room=$post_info&mode=edit\">Edit</a></tr>\n";
echo "</tbody></table>";

echo "<br/>";

// opening tags for a table, adds a heading also
// heading must be of the form
// <tr><td colspan=2>My Heading</td></tr></thead>
function table_start($heading_tag){
	echo "<table class=\"default\">\n";	
	echo "<thead class=\"default\">\n";
	echo $heading_tag;
	echo "</thead>\n";
	echo "<tbody class=\"default\">\n";
}

// end tags for a table
function table_end(){
	echo "</tbody></table>\n";
}

// forms a table of teaching duties for $id
// it is formatted similar to the teaching schedule for employeeinfo.php
function teaching_duties_query($id,$first,$last){
	$query2 = "select room_num as Room,days as Days,time as Time,term as Semester,year as Year from employee e,class c where e.id = '$id' and e.id = c.teacher_id order by year,term,room_num";
	$result2 = mysql_query((string)$query2) or die('BAD QUERY '.mysql_error());

	if(mysql_num_rows($result2) != 0){
		echo "<br/>";
		echo "<table class=\"default\">";
		echo "<thead class=\"default\">";
		echo "<tr><td colspan=5>Teaching Schedule for $first $last</td></tr></thead>";	
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
}

// grabs office hours for employee if the room is an office
function display_office_hours($id){
	$query = "select * from employee e,officehours o where e.id = '$id' and e.id = o.id order by o.day";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	echo "\n";
	$row = mysql_fetch_assoc($result);
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
	mysql_free_result($result);
}

// if the room is a lab, we display the appropriate information
if($post_type == "lab"){
	// determine whether the lab is a computerlab or research lab
	$query = "select count(*) as count from room r, computerlab cl where r.room_num = cl.room_num and r.room_num = '$post_info'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	
	$row = mysql_fetch_assoc($result);
	if($row['count'] == 1){
		$use_rlab = 0;
	}
	else{
		$use_rlab = 1;
	}
	
	mysql_free_result($result);

	if($use_rlab == 0){
	// If the room is a computer laboratory, display the purpose of the lab, the number and 
	// type of the computers, the contact person, and hours of operation.
	
		$query = "select cl.num_computers as num, cl.type_computers as type, cl.hours as hours, cl.days as days, cl.contact_id as id, cl.purpose as purpose, e.firstname as first, e.lastname as last from room r, computerlab cl, employee e where r.room_num = '$post_info' and r.room_num = cl.room_num and cl.contact_id = e.id";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			
		echo "<table class=\"default\">";
		echo "<thead class=\"default\">";
		echo "<tr><td colspan=9 align=center>Computer Lab: Room #$post_info</td></tr></thead>";	
	
		echo "<tbody class=\"default\">";
	
		$row = mysql_fetch_assoc($result);
		$num = $row['num'];
		$type = ucwords($row['type']);
		$hours = $row['hours'];
		$days = strtoupper($row['days']);
		$id = $row['id'];
		$purpose = ucwords($row['purpose']);
		$first = $row['first'];
		$last = $row['last'];
		echo "<tr><td>Number of computers:</td><td>$num</td></tr>";
		echo "<tr><td>Type of computers:</td><td>$type</td></tr>";
		echo "<tr><td>Days Open:</td><td>$days</td></tr>";
		echo "<tr><td>Hours Open:</td><td>$hours</td></tr>";
		echo "<tr><td>Contact Person:</td><td><a href=\"employeeinfo.php?id=$id\">$first $last</a></td></tr>";
		echo "<tr><td colspan=2>Purpose:</td></tr>";			
		echo "<tr><td colspan=2 align=center>$purpose</td></tr>";
		table_end();
	}
	else{
	// If the room is a research laboratory, display the purpose of the lab, the contact 
  	// person, and hours of operation.

	//researchlab	[room_num]	[contact_id]	[hours]	[days]	[purpose]

		$query = "select rl.hours as hours, rl.days as days, rl.contact_id as id, rl.purpose as purpose, e.firstname as first, e.lastname as last from room r, researchlab rl, employee e where r.room_num = '$post_info' and r.room_num = rl.room_num and rl.contact_id = e.id";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			
		echo "<table class=\"default\">";
		echo "<thead class=\"default\">";
		echo "<tr><td colspan=9 align=center>Research Lab: Room #$post_info</td></tr></thead>";	
	
		echo "<tbody class=\"default\">";
	
		$row = mysql_fetch_assoc($result);
		$hours = $row['hours'];
		$days = strtoupper($row['days']);
		$id = $row['id'];
		$purpose = ucwords($row['purpose']);
		$first = $row['first'];
		$last = $row['last'];
		echo "<tr><td>Days Open:</td><td>$days</td></tr>";
		echo "<tr><td>Hours Open:</td><td>$hours</td></tr>";
		echo "<tr><td>Contact Person:</td><td><a href=\"employeeinfo.php?id=$id\">$first $last</a></td></tr>";
		echo "<tr><td colspan=2>Purpose:</td></tr>";			
		echo "<tr><td colspan=2 align=center>$purpose</td></tr>";
		table_end();
	}
	mysql_free_result($result);
}
// show classes in the room if it is a classroom
else if($post_type == "lecture"){
	// If the room is a classroom, display a schedule of all classes meeting in it during the 
	// current term.  Include a link to the faculty member teaching the class.
	
	$query = "select year,term,course_num as CourseNum,course_id as CourseId,section,days,time,level,teacher_id from class where room_num = '$post_info' order by year,term,course_num,course_id,section,level";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	
	$query2 = "select num_seats from classroom where room = '$post_info'";
	$result2 = mysql_query((string)$query2) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result2);
	$seats = $row['num_seats'];
	mysql_free_result($result2);

	echo "<table class=\"default\">";
	echo "<thead class=\"default\">";
	echo "<tr><td colspan=9 align=center>Schedule of classes for room #$post_info ($seats Seats)</td></tr></thead>";	
	echo "<thead class=\"default\"><tr>";
	for ($i=0; $i < (mysql_num_fields($result) - 1); $i++){
		$field_name = mysql_field_name($result, $i);
		echo "<td>".ucwords($field_name)."</td>";
	}
	echo "<td>Link</td>";
	echo "</tr></thead>";

	echo "<tbody class=\"default\">";


	$i = 0;
	while($i < mysql_num_rows($result)){
		$row = mysql_fetch_assoc($result);
		$year = $row['year'];
		$term = $row['term'];
		$crs_num = $row['CourseNum'];
		$crs_id = $row['CourseId'];
		$sect = $row['section'];
		$days = strtoupper($row['days']);
		$time = $row['time'];
		$level = $row['level'];
		$id = $row['teacher_id'];
		echo "<tr>";
		echo "<td>$year</td>";
		echo "<td>$term</td>";
		echo "<td>$crs_num</td>";
		echo "<td>$crs_id</td>";
		echo "<td>$sect</td>";
		echo "<td>$days</td>";
		echo "<td>$time</td>";
		echo "<td>$level</td>";
		echo "<td><a href=\"employeeinfo.php?id=$id\">Instructor</a></td>";
		echo "</tr>";
		$i = $i + 1;
	}
	table_end();
}
// show occupant of office
else if($post_type == "office"){
	// display name, photo, and schedule of occupant
	// schedule consists of office hours and possibly teaching duties
	$query = "select e.firstname as First, e.lastname as Last, e.photo as Photo,e.id as Id from employee e, office o where o.room = '$post_info' and o.occupant_id = e.id";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result);
	$id = $row['Id'];
	$first = $row['First'];
	$last = $row['Last'];
	$photo = $row['Photo'];
	
	echo "\n";
	table_start("<tr><td colspan=2>Office #$post_info</td></tr>");
	if(mysql_num_rows($result) == 0){
		echo "<tr><td>Office is unoccupied.</td></tr>";
		table_end();
	}
	else{
		echo "<tr><td>Firstname</td><td>$first</td></tr>";
		echo "<tr><td>Lastname</td><td>$last</td></tr>";
		echo "<tr><td>Photo</td><td><img src=\"../$photo\" width=200></td></tr>";
		echo "<tr><td colspan=2 align=center>Office Hours</td></tr>\n";
		display_office_hours($id);
		table_end();
		teaching_duties_query($id,$first,$last);
	}
	
	mysql_free_result($result);	
}
// show seminars held in this room
else if($post_type == "seminar"){
	// If the room is a seminar room, display a schedule of all activities currently 
	// scheduled in the room.  Each activity will include a contact person (name, phone, 
	// and office), the date, the starting and ending times, and a brief description of the 
	// purpose.
	
	$query = "select e.id as id, e.firstname as fn, e.lastname as ln, e.phone as ph, e.office_num as ofn, s.date as d, s.time as t, s.purpose as purp from seminar s, employee e where s.room_num = '$post_info' and s.contact_id = e.id order by date,time";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

	echo "<table class=\"default\">\n";	
	echo "<thead class=\"default\">\n";
	echo "<tr><td colspan=8 align=center>Events in seminar room #$post_info</td></tr>";
	echo "</thead>\n";
	if(mysql_num_rows($result) == 0){
		echo "<tbody class=\"default\">\n";
		echo "<tr><td>No events scheduled.</td></tr>";
		table_end();
	}
	else{
		echo "<thead class=\"default\"><tr>";
		echo "<td>Contact Name</td><td>Contact Ph#</td><td>Office</td><td>Date</td><td>Time</td><td>Purpose</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">\n";
		
		$i = 0;
		while($i < mysql_num_rows($result)){
			$row = mysql_fetch_assoc($result);
			$id = $row['id'];		
			$first = $row['fn'];
			$last = $row['ln'];
			$phone = $row['ph'];
			$office = $row['ofn'];
			$date = $row['d'];
			$time = $row['t'];
			$purpose = $row['purp'];
	
			echo "<tr>";
			echo "<td><a href=\"employeeinfo.php?id=$id\">$first $last</a></td>";
			echo "<td>$phone</td>";
			echo "<td>$office</td>";
			echo "<td>$date</td>";
			echo "<td>$time</td>";
			echo "<td>$purpose</td>";
			echo "</tr>";
			$i = $i + 1;
		}
		table_end();
	}		
	mysql_free_result($result);
}
// no information to show if 'other' type of room
else if($post_type == "other"){
	echo "<table class=\"default\">\n";	
	echo "<thead class=\"default\">\n";
	echo "<tr><td colspan=2 align=center>Information for room #$post_info</td></tr>";
	echo "</thead>\n";
	echo "<tbody class=\"default\">\n";
	echo "<tr><td>Type:</td><td>Other</td></tr>";
	table_end();	
}
else{
	echo "ERROR: BAD GET INFO!<br/>";
}
?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
