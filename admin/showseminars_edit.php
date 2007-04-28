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

Shows all seminars and allows editing/deleting/adding of seminars.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php

$mode = (string)$_GET['mode'];
$g_room = (string)$_GET['r'];
$g_date = (string)$_GET['d'];
$g_time = (string)$_GET['t'];

if($mode == ""){ $mode = "show"; }
$redirect="showseminars_edit.php?mode=show";        // redirect to page

// returns a hyperlink to a javascript popup message
function popuplink($msg,$linktext){
	return "<a href=\"javascript:alert('$msg')\">$linktext</a>";
}

// pops up a javascript message box and then redirects to another page
function redirect($msg, $location){
	echo "<script language=\"javascript\">\n alert(\"".$msg."\"); \n window.location = \"".$location."\"; \n</script>";	
}
// show the form to add a seminar
if($mode == "add"){
	echo "<table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td colspan=2 align=center>Add Seminar</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	echo "<FORM method=\"post\" action=\"showseminars_edit.php?mode=addnow\">";
	echo "<tr><td>Room</td>";
		echo "<td><select name=\"room\">";
		$query = "select room_num from room where room_type = 'seminar' order by room_num";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$room_num = $row['room_num'];
			echo "<option value=\"$room_num\">Room $room_num</option>";
		}
		mysql_free_result($result);
		echo "</select></td></tr>";		
	echo "<tr><td>Contact</td><td>";
		echo "<select name=\"contact\">";
		$query = "select id,firstname,lastname from employee order by lastname, firstname";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$t_id = $row['id'];
			$t_fn = $row['firstname'];
			$t_ln = $row['lastname'];
			echo "<option value=\"$t_id\">$t_fn $t_ln</option>";
		}
		mysql_free_result($result);
		echo "</select>";		
	echo "</td></tr>";
	echo "<tr><td>Date</td><td><input name=\"date\" type=text size=10 maxlength=10> ".popuplink("Date must be formatted like YYYY-MM-DD. For example: 2007-05-22.", "?")."</td></tr>";
	echo "<tr><td>Time</td><td>";
		echo "<select name=\"stime\">";
		$i = 1;
		while($i <= 12){
			echo "<option value=\"$i:00\">$i:00</option>";
			echo "<option value=\"$i:15\">$i:15</option>";
			echo "<option value=\"$i:30\">$i:30</option>";
			echo "<option value=\"$i:45\">$i:45</option>";
			$i = $i + 1;
		}
		echo "</select>";		

		echo "<select name=\"stimep\">";
		echo "<option value=\"P\">PM</option>";
		echo "<option value=\"A\">AM</option>";
		echo "</select>";		
		echo " - ";
		echo "<select name=\"etime\">";
		$i = 1;
		while($i <= 12){
			echo "<option value=\"$i:00\">$i:00</option>";
			echo "<option value=\"$i:15\">$i:15</option>";
			echo "<option value=\"$i:30\">$i:30</option>";
			echo "<option value=\"$i:45\">$i:45</option>";
			$i = $i + 1;
		}
		echo "</select>";		

		echo "<select name=\"etimep\">";
		echo "<option value=\"P\">PM</option>";
		echo "<option value=\"A\">AM</option>";
		echo "</select>";		
	echo "</td></tr>";
	echo "<tr><td>Purpose</td><td><input name=\"purpose\" type=text size=30 maxlength=50></td></tr>";
	echo "<tr><td colspan=2 align=center><input type=\"submit\" value=\"Submit\"></td></tr>";
	echo "</FORM>";
	echo "</tbody>";
	echo "</table>";
}
// add has been submitted and now we do an insert
else if($mode == "addnow"){
	$room = (string)$_POST['room'];
	$contact = (string)$_POST['contact'];
	$date = (string)$_POST['date'];
	$time = $_POST['stime'].$_POST['stimep']."-".$_POST['etime'].$_POST['etimep'];
	$purpose = (string)$_POST['purpose'];

	$tmp = explode("-", $date);
	if(count($tmp) == 3 && strlen((int)$tmp[0]) == 4 && strlen((int)$tmp[1]) >= 1 && strlen((int)$tmp[2]) >= 1 && strlen($date) == 10 && ((int)$tmp[0]) != 0 && ((int)$tmp[1]) != 0 && ((int)$tmp[2]) != 0 && ((int)$tmp[1]) <= 12 && ((int)$tmp[2]) <= 31){
		$query = "select count(*) as count from seminar where room_num = '$room' and date = '$date' and time = '$time'";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		$count = $row['count'];
		if($count == 0){
			$query = "insert into seminar values ('$room', '$contact', '$date', '$time', '$purpose')";
			mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			redirect("Insertion was successful.", $redirect);
			
		}
		else{
			redirect("Error: Seminar already exists.", $redirect);
		}
	}
	else{
		echo count($tmp)." - ".strlen((int)$tmp[0])." - ".strlen((int)$tmp[1])." - ".strlen((int)$tmp[2])." - ".strlen($date)." - ".((int)$tmp[0])." - ".((int)$tmp[1])." - ".((int)$tmp[2])." - ".((int)$tmp[1])." - ".((int)$tmp[2]);
		redirect("Error: Improper date.", $redirect);
	}

	$query = "insert into officehours values ('$id', '$day', '$time')";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Office hours added successfully.", "officehours_edit.php?mode=show&id=$id");
}
// user wishes to delete a seminar
else if($mode == "del"){
	$confirm = (string)$_GET['c'];
	if($confirm == "yes"){
		$query = "delete from seminar where date = '$g_date' and time = '$g_time' and room_num = '$g_room'";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		redirect("Deleted selected seminar.", $redirect);
	}
	else{	
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td align=center>Confirm Delete</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
		echo "<tr><td><a href=\"showseminars_edit.php?mode=del&d=$g_date&t=$g_time&r=$g_room&c=yes\">Delete Seminar</a></td></tr>";
		echo "</tbody>";
		echo "</table>";
	}
}
// delete all seminars
else if($mode == "delall"){
	$confirm = (string)$_GET['c'];
	if($confirm == "yes"){
		$query = "delete from seminar";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		redirect("Deleted all seminars.", $redirect);
	}
	else{	
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td align=center>Confirm Delete</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
		echo "<tr><td><a href=\"showseminars_edit.php?mode=delall&c=yes\">Delete ALL Seminars</a></td></tr>";
		echo "</tbody>";
		echo "</table>";
	}
}
// show all seminars for the room
else if($mode == "show"){
	$query = "select firstname,lastname from employee where id = '$id'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	$fn = $row['firstname'];
	$ln = $row['lastname'];
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td colspan=2 align=center>Manage Seminars</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	echo "<tr><td><a href=\"showseminars_edit.php?mode=delall\">Delete All</a></td><td><a href=\"showseminars_edit.php?mode=add\">Add</a></td></tr>";
	echo "</tbody>";
	echo "</table>";

	$query = "select room_num, contact_id, date, time, purpose, firstname, lastname from seminar s, employee e where s.contact_id = e.id order by date, time, room_num, lastname, firstname";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\">";
	echo "<tr><td colspan=7 align=center>All Seminars</td></tr></thead>";	
	echo "<thead class=\"default\">";
	echo "<tr><td>Room</td><td>Contact</td><td>Date</td><td>Time</td><td>Purpose</td><td>Manage</td></tr></thead>";	

	echo "<tbody class=\"default\">";

	if(mysql_num_rows($result) == 0){
		echo "<tr><td colspan=7>None</td></tr>";	
	}
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
		echo "<td><a href=\"roominfo.php?room=$room&type=".$row['room_type']."\">$room</a></td>";
		echo "<td><a href=\"employeeinfo.php?id=$id\">$first $last</a></td>";
		echo "<td>$date</td>";
		echo "<td>$time</td>";
		echo "<td>$purpose</td>";
		echo "<td><a href=\"showseminars_edit.php?mode=del&r=$room&d=$date&t=$time\">Delete</a></td>";
		echo "</tr>";
	}
	echo "</td></tbody></table>";
	mysql_free_result($result);}
else{
	redirect("ERROR: BAD GET INFO!", $redirect);
}

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
