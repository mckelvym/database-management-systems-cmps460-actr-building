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

$mode = (string)$_GET['mode']; // add,edit,del,delall
$date = (string)$_GET['d'];    
$time = (string)$_GET['t'];
$location = (string)$_GET['l'];
$redirect="events.php";        // redirect to page

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

// checks the data of the add form for some semi-correctness before proceeding
// returns true if it is ok, false if not.
function checkdata($post_date, $post_time, $post_location, $post_contact){
	$checkstring = "";
	
	// check for a decently formatted date
	$tmp = explode("-", $post_date);
	if(count($tmp) == 3 && strlen((int)$tmp[0]) == 4 && strlen((int)$tmp[1]) >= 1 && strlen((int)$tmp[2]) >= 1 && strlen($post_date) == 10 && ((int)$tmp[0]) != 0 && ((int)$tmp[1]) != 0 && ((int)$tmp[2]) != 0 && ((int)$tmp[1]) <= 12 && ((int)$tmp[2]) <= 31){
		$checkstring = $checkstring.".";
	}

	// check for a decently formatted time
	$tmp = explode("-", $post_time);
	if(count($tmp) == 2){
		$part1 = explode(":", $tmp[0]);
		$part2 = explode(":", $tmp[1]);
		if(count($tmp) == 2 && strlen($tmp[0]) >= 5 && strlen($tmp[1]) >= 5 && strlen($post_time) >= 11 && strlen($post_time) <= 13 && ((int)$part1[0]) != 0 && ((int)$part2[0]) != 0){
			$checkstring = $checkstring.".";
		}
	}
	
	// check that location is not empty
	if(strlen($post_location) > 0){
		$checkstring = $checkstring.".";
	}

	// check for a decently formatted contact id
	$tmp = explode("-", $post_contact);
	if(count($tmp) == 3 && strlen($tmp[0]) == 3 && strlen($tmp[1]) == 2 && strlen($tmp[2]) == 4){
		$checkstring = $checkstring.".";
	}

	// passed all conditions
	if(strlen($checkstring) == 4){
		return true;
	}
	return false;
}

// shows the edit/add form
// values passed or for if it is an edit form, the fields will be 
// populated with the correct data
function show_form($mode, $dval, $tval, $lval, $cval, $pval){
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td colspan=2 align=center>".ucwords($mode)." Event</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	echo "<FORM method=\"post\" action=\"event_edit.php?mode=$mode&d=$dval&t=$tval&l=$lval\">";
	echo "<tr><td colspan=2 align=right>".popuplink("Primary keys are (date,time,location), therefore they must be unique.", "Help")."</td></tr>";
	// if this is an edit form, the primary key fields will be disabled from edit
	if($mode == "edit"){
		echo "<tr><td>Date:</td><td><input disabled type=\"text\" name=\"date\" value=\"$dval\" size=\"10\" maxlength=\"10\"></td></tr>";
		echo "<tr><td>Time:</td><td><input disabled type=\"text\" name=\"time\" value=\"$tval\" size=\"13\" maxlength=\"13\">";
 		echo "</td></tr>";
		echo "<tr><td>Location:</td><td><input disabled type=\"text\" name=\"location\" value=\"$lval\" size=\"50\" maxlength=\"250\"></td></tr>";
	}
	else{
		echo "<tr><td>Date*:</td><td><input type=\"text\" name=\"date\" value=\"$dval\" size=\"10\" maxlength=\"10\"> ".popuplink("Date must be formatted like YYYY-MM-DD. For example: 2007-05-22.", "?")."</td></tr>";
		echo "<tr><td>Time*:</td><td><input type=\"text\" name=\"time\" value=\"$tval\" size=\"13\" maxlength=\"13\"> ".popuplink("Time must be formatted like H:MMA-H:MMP. For example, the following are acceptable: 3:00A-3:30A; 3:00P-3:30P; 10:00A-10:00P; 12:00P-1:00A.", "?")."</td></tr>";
		echo "<tr><td>Location*:</td><td><input type=\"text\" name=\"location\" value=\"$lval\" size=\"50\" maxlength=\"250\"> ".popuplink("Location must be unique, and can be up to 250 characters.", "?")."</td></tr>";
	}
	echo "<tr><td>Contact</td><td>";
	echo "<select name=\"contact\">";
	$query = "select id,lastname,firstname from employee order by lastname, firstname";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	while($row = mysql_fetch_assoc($result)){
		$id = $row['id'];
		$fn = $row['firstname'];
		$ln = $row['lastname'];
		echo "<option value=\"$id\">$fn $ln</option>";
	}
	mysql_free_result($result);
 	echo "</select></td></tr>";

	echo "<tr><td>Purpose</td><td><input type=\"text\" name=\"purpose\" value=\"$pval\" size=\"50\" maxlength=\"250\"></td></tr>";
	echo "<tr><td colspan=2 align=center><input type=\"submit\" value=\"Submit ".ucwords($mode)."\"></td></tr>";
	echo "</FORM>";
	echo "</tbody>";
	echo "</table>";
}

// somehow there was no mode, so redirect
if($mode == ""){
	echo "<script language=\"javascript\">\n window.location = \"".$redirect."\"; \n</script>";	
}

// edit an event
if($mode == "edit"){
	// get contact id and purpose so we can populate all fields
	$query = "select contact_id,purpose from events where date = '$date' and time = '$time' and location = '$location'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result);
	$contact = $row['contact_id'];
	$purpose = $row['purpose'];
	mysql_free_result($result);	

	// if the form has been submitted, these variables should contain information
	$post_contact = (string)$_POST['contact'];
	$post_purpose = str_replace("'", "", (string)$_POST['purpose']);
	
	// form has been submitted with new information, handle it accordingly
	if(!($post_contact == "")){
		// check for a decently formatted contact id
		$tmp = explode("-", $post_contact);
		if(count($tmp) == 3 && strlen($tmp[0]) == 3 && strlen($tmp[1]) == 2 && strlen($tmp[2]) == 4){
			$oktogo = true;
		}else{ $oktogo = false; }

		if(!$oktogo){ redirect("There was an error processing the data, no changes will be made.", $redirect); }
		else{
			// make sure that the employee exists before changing any data
			$query = "select count(*) as count from employee where id = '$post_contact'";
			$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			$row = mysql_fetch_assoc($result);
			$count_emp = (int)$row['count'];
			mysql_free_result($result);
			
			// if that employee doesn't exist, redirect
			if($count_emp == 0){ redirect("Employee does not exist, no changes will be made.", $redirect); }
			else{
				// employee exists, so update the information
				$query = "update events set contact_id = '$post_contact', purpose = '$post_purpose' where date = '$date' and time = '$time' and location = '$location'";
				mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
				redirect("Event has been updated.", $redirect);			
			}
		}
	}
	else{
		// form has not been submitted so it needs to be populated with data
		show_form($mode, $date, $time, $location, $contact, $purpose);
	}
}
// add an event
else if($mode == "add"){
	// information from after a submit
	$post_date = (string)$_POST['date'];
	$post_time = (string)$_POST['time'];
	$post_location = (string)$_POST['location'];
	$post_contact = (string)$_POST['contact'];
	$post_purpose = (string)$_POST['purpose'];
	
	// this is the state for after a submit, that checks all the data
	if(!($post_date == "" && $post_time == "" && $post_location == "" && $post_contact == "")){
		// preliminary checking of the data
		$oktogo = checkdata($post_date, $post_time, $post_location, $post_contact);
		if(!$oktogo){ redirect("There was an error processing the data, no changes will be made.", $redirect); }
		else{
			// making sure we aren't clashing with another event
			$query = "select count(*) as count from events where date = '$post_date' and time = '$post_time' and location = '$post_location'";
			$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			$row = mysql_fetch_assoc($result);
			$count_events = (int)$row['count'];
			mysql_free_result($result);

			// making sure that the employee exists
			$query = "select count(*) as count from employee where id = '$post_contact'";
			$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			$row = mysql_fetch_assoc($result);
			$count_emp = (int)$row['count'];
			mysql_free_result($result);
			
			// if event already exists or employee doesn't exist, redirect. otherwise continue inserting
			if($count_events == 1 || $count_emp == 0){ 
				redirect("Event already exists or employee does not exist, no changes will be made.", $redirect); 
			}
			else{
				// insert data into db
				$query = "insert into events values (\"$post_date\", \"$post_time\", \"$post_contact\", \"$post_location\", \"$post_purpose\")";
				mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
				redirect("Event has been added.", $redirect);			
			}
		}
	}
	else{
		// form has not been submitted so show it.
		show_form($mode, "", "", "", "", "");
	}
}
// delete a single event
else if($mode == "del"){
	// this is get data from if the user confirmed to delete the event
	$confirm = (string)$_GET['confirm'];

	// making sure that we have the get data
	if(!($date == "" && $time == "" && $location == "")){
		// user confirmed that they want to delete the event
		if($confirm == 'y'){	
			$query = "delete from events where date = '$date' and time = '$time' and location = '$location'";
			mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			echo "<script language=\"javascript\">\n alert(\"Event has been deleted.\"); \n window.location = \"".$redirect."\"; \n</script>";	
		}	
		// user has not yet confirmed they want to delete the event, so give them the choice
		else{
			echo "<br/><table class=\"default\">";
			echo "<thead class=\"default\"><tr>";
			echo "<td colspan=2>Confirm Deletion of Event</td>";
			echo "</tr></thead>";
			echo "<tbody class=\"default\">";
			echo "<tr><td><a href=\"event_edit.php?mode=del&d=$date&t=$time&l=$location&confirm=y\">Confirm by clicking here</a></td></tr>";
			echo "</tbody>";
			echo "</table>";
		}
	}	
}
// delete all events
else if($mode == "delall"){
	// get data for a confirmation
	$confirm = (string)$_GET['confirm'];
	// user has confirmed they wish to delete all events
	if($confirm == 'y'){	
		$query = "delete from events";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		echo "<script language=\"javascript\">\n alert(\"All events have been deleted.\"); \n window.location = \"".$redirect."\"; \n</script>";	
	}	
	// user hasn't yet confirmed they wish to delete all events, so give them the choice
	else{
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2>Confirm Deletion of ALL Events</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
		echo "<tr><td><a href=\"event_edit.php?mode=delall&confirm=y\">Confirm deletion of ALL events by clicking here</a></td></tr>";
		echo "</tbody>";
		echo "</table>";
	}		
}
else{
	// if for some strange reason you end up here...then redirect 
	echo "<script language=\"javascript\">\n window.location = \"".$redirect."\"; \n</script>";	
}

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
