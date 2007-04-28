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

Allows editing of a certain employee's office hours, deleting, adding, etc.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php

// get information for editing/deleting, etc
$id = (string)$_GET['id'];
$day = (string)$_GET['day'];
$time = (string)$_GET['time'];
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

// add office hours for an employee
if($mode == "add"){
	$days = array("m","t","w","r","f","s","u");
	$d = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

	// show form
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td colspan=2 align=center>Add office hours</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	echo "<FORM method=\"post\" action=\"officehours_edit.php?mode=addnow&id=$id\">";
	echo "<tr><td>Day</td>";
		echo "<td><select name=\"day\">";
		$i = 0;
		while($i < count($days)){
			echo "<option value=\"".$days[$i]."\">".$d[$i]."</option>";
			$i = $i + 1;
		}
		echo "</select></td></tr>";	
	// drop downs for times	
	echo "<tr><td>Times</td><td>";
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
	echo "<tr><td colspan=2 align=center><input type=\"submit\" value=\"Submit\"></td></tr>";
	echo "</FORM>";
	echo "</tbody>";
	echo "</table>";
}
// inserts new office hours
else if($mode == "addnow"){
	$day = (string)$_POST['day'];
	$time = $_POST['stime'].$_POST['stimep']."-".$_POST['etime'].$_POST['etimep'];
	$query = "insert into officehours values ('$id', '$day', '$time')";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Office hours added successfully.", "officehours_edit.php?mode=show&id=$id");
}
// delete an employee's office hourse
else if($mode == "del"){
	$query = "delete from officehours where day = '$day' and time = '$time' and id = '$id'";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Deleted selected office hour.", "officehours_edit.php?id=$id");	
}
// delete all office hours for all employees
else if($mode == "delall"){
	$query = "delete from officehours where id = '$id'";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Deleted all office hours for employee.", $redirect);
}
// show office hours for a specific employee
else if($mode == "show"){
	$query = "select firstname,lastname from employee where id = '$id'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	$fn = $row['firstname'];
	$ln = $row['lastname'];
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td colspan=2 align=center>Manage Officehours ($fn $ln)</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	echo "<tr><td><a href=\"officehours_edit.php?id=$id&mode=delall\">Delete All</a></td><td><a href=\"officehours_edit.php?id=$id&mode=add\">Add</a></td></tr>";
	echo "</tbody>";
	echo "</table>";

	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td>Day</td><td>Time</td><td>Manage</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	$query = "select day, time from officehours where id = '$id'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	if(mysql_num_rows($result) == 0){
		echo "<tr><td colspan=3>None</td></tr>";
	}
	while($row = mysql_fetch_assoc($result)){
		$day = $row['day'];
		$time = $row['time'];

		if($day == "m"){ $d = "Monday"; }
		if($day == "t"){ $d = "Tuesday"; }
		if($day == "w"){ $d = "Wednesday"; }
		if($day == "r"){ $d = "Thursday"; }
		if($day == "f"){ $d = "Friday"; }
		if($day == "s"){ $d = "Saturday"; }
		if($day == "u"){ $d = "Sunday"; }
		echo "<tr><td>$d</td><td>$time</td><td><a href=\"officehours_edit.php?id=$id&mode=del&day=$day&time=$time\">Delete</a></td></tr>";
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
