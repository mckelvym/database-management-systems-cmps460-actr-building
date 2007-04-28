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

$id = (string)$_GET['id'];
$mode = (string)$_GET['mode'];
$p_id = (string)$_POST['id'];
$p_lastname = (string)$_POST['lastname'];
$p_firstname = (string)$_POST['firstname'];
$p_office = (string)$_POST['office'];
$p_phone = (string)$_POST['phone'];
$p_photo = (string)$_POST['photo'];
$p_website = (string)$_POST['website'];
$p_position = (string)$_POST['position'];

$redirect="employee.php";        // redirect to page

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

// shows the edit/add form
// values passed or for if it is an edit form, the fields will be 
// populated with the correct data
function show_form($mode, $ival, $lval, $fval, $oval, $phval, $picval, $wval, $pval){
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td colspan=2 align=center>".ucwords($mode)." Employee</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	echo "<FORM method=\"post\" action=\"employee_edit.php?mode=$mode&id=$ival&mode=$mode&s=s\">";
	echo "<tr><td colspan=2 align=right>".popuplink("Primary key is ID, therefore it must be unique. Lastname and position do not have to be unique, but they are required.", "Help")."</td></tr>";
	if($mode == "edit"){
		echo "<tr><td>ID</td><td><input disabled type=\"text\" name=\"id\" value=\"$ival\" size=13 maxlength=13> ".popuplink("ID should look something like an SSN, 111-11-1111.", "?")."</td></tr>";
	}
	else{
		echo "<tr><td>ID*</td><td><input type=\"text\" name=\"id\" value=\"$ival\" size=13 maxlength=13> ".popuplink("ID should look something like an SSN, 111-11-1111.", "?")."</td></tr>";
	}
	echo "<tr><td>Lastname*</td><td><input type=\"text\" name=\"lastname\" value=\"$lval\" size=20 maxlength=50></td></tr>";
	echo "<tr><td>Firstname</td><td><input type=\"text\" name=\"firstname\" value=\"$fval\" size=20 maxlength=50></td></tr>";
	echo "<tr><td>Office #</td><td>";
		echo "<select name=\"office\"><option selected value=\"$oval\" >Room $oval</option>";
		$query = "select room from office where occupant_id = 'unoccupied'";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$room = $row['room'];
			echo "<option value=\"$room\">Room $room</option>";
		}
		mysql_free_result($result);
	 	echo "</select></td></tr>";
	echo "<tr><td>Phone #</td><td><input type=\"text\" name=\"phone\" value=\"$phval\" size=12 maxlength=14></td></tr>";
	echo "<tr><td>Photo name</td><td><input type=\"text\" name=\"photo\" value=\"$picval\" size=20 maxlength=50></td></tr>";
	echo "<tr><td>Website URL</td><td><input type=\"text\" name=\"website\" value=\"$wval\" size=50 maxlength=250></td></tr>";
	echo "<tr><td>Position</td><td>";
		echo "<select name=\"position\"><option value=\"\" >Select Position</option>";
		$positions = array("faculty", "secretary", "teaching assistant", "research assistant", "grader");
		$i = 0;
		while($i < count($positions)){
			if($positions[$i] == $pval){
				echo "<option selected value=\"".$positions[$i]."\">".ucwords($positions[$i])."</option>";
			}
			else{
				echo "<option value=\"".$positions[$i]."\">".ucwords($positions[$i])."</option>";
			}
			$i = $i + 1;
		}
		echo "</select></td></tr>";		
	echo "<tr><td colspan=2 align=center><input type=\"submit\" value=\"Submit ".ucwords($mode)."\"></td></tr>";
	echo "</FORM>";
	echo "</tbody>";
	echo "</table>";
}


if($mode == "edit"){
	if($p_lastname == "" || $p_position == ""){
		$query = "select lastname,firstname,office_num,phone,photo,website,position from employee where id = '$id'";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$row = mysql_fetch_assoc($result);
		$last = $row['lastname'];
		$first = $row['firstname'];
		$office = $row['office_num'];
		$phone = $row['phone'];
		$photo = $row['photo'];
		$website = $row['website'];
		$position = $row['position'];

		show_form($mode, $id, $last, $first, $office, $phone, $photo, $website, $position);
	}
	else{
		$query = "select occupant_id from office where room = '$p_office'"; 
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		$query = "update employee set lastname = '$p_lastname', firstname = '$p_firstname', office_num = '$p_office', phone = '$p_phone', photo = '$p_photo', website = '$p_website', position = '$p_position' where id = '$id'";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$query = "update office set occupant_id = '$id' where room = '$p_office'";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		redirect("Employee edited successfully.", $redirect);	
	}
}
else if($mode == "add"){
	$check = (string)$_GET['s'];

	if($p_id == "" || $p_lastname == "" || $p_position == ""){
		if($check == "s"){
			popup("Error in required fields, please try again.");
		}
		show_form($mode, "", "", "", "", "", "", "", "");
	}
	else{
		$oktogo = true;		
		$tmp = explode("-", $p_id);


		if(count($tmp) != 3){ $oktogo = false; }
		if($oktogo && (strlen($tmp[0]) != 3 || strlen($tmp[1]) != 2 || strlen($tmp[2]) != 4)){ $oktogo = false; }
		if($oktogo){
			$query = "select count(*) as count from employee where id = '$p_id'";
			$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			$row = mysql_fetch_assoc($result);
			mysql_free_result($result);
			$query = "select occupant_id from office where room = '$p_office'"; 
			$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			$row2 = mysql_fetch_assoc($result);
			mysql_free_result($result);
			
			if($row['count'] == 0 && $row2['occupant_id'] == "unoccupied"){
				$query = "insert into employee values ('$p_id', '$p_lastname', '$p_firstname', '$p_office', '$p_phone', '$p_photo', '$p_website', '$p_position')";
				mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
				$query = "update office set occupant_id = '$p_id' where room = '$p_office'";
				mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	
				redirect("Employee added successfully.", $redirect);
			}
			else{
				redirect("Error: employee already exists in the database or office taken.", $redirect);
			}
		}
		else{
			redirect("Error in ID. Employee will not be inserted.", $redirect);
		}		
	}
}
else if($mode == "del"){
	// check officehours, events, seminars, offices, computer labs, research labs, and classes, drop necessary entries
	$confirm = (string)$_GET['c'];
	if($confirm == "yes"){
		$query = array("delete from officehours where id = '$id'", "delete from events where contact_id = '$id'", "delete from seminar where contact_id = '$id'", "update office set occupant_id = 'unoccupied' where occupant_id = '$id'", "delete from computerlab where contact_id = '$id'", "delete from researchlab where contact_id = '$id'", "delete from class where teacher_id = '$id'", "delete from employee where id = '$id'");
		$i = 0;
		while($i < count($query)){
			mysql_query((string)$query[$i]) or die('BAD QUERY '.mysql_error());
			$i = $i + 1;		
		}
		redirect("All information relating to the employee has been deleted.", $redirect);
	}
	else{
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2>Confirm Deletion of Employee</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
		echo "<tr><td>Please be aware that all office hours, events, seminars, computer labs, research labs, and classes that have the matching employee will be deleted including the current employee. </td></tr>";
		echo "<tr><td><a href=\"employee_edit.php?mode=del&id=$id&c=yes\">Confirm Deletion</a></td></tr>";
		echo "</tbody>";
		echo "</table>";
	}
}
else if($mode == "delall"){
	// check officehours, events, seminars, offices, computer labs, research labs, and classes, drop necessary entries
	$confirm = (string)$_GET['c'];
	if($confirm == "yes"){
		$bigquery = "select id from employee";
		$bigresult = mysql_query((string)$bigquery) or die('BAD QUERY '.mysql_error());
		while($row = mysql_fetch_assoc($bigresult)){
			$id = $row['id'];
			$query = array("delete from officehours where id = '$id'", "delete from events where contact_id = '$id'", "delete from seminar where contact_id = '$id'", "update office set occupant_id = 'unoccupied' where occupant_id = '$id'", "delete from computerlab where contact_id = '$id'", "delete from researchlab where contact_id = '$id'", "delete from class where teacher_id = '$id'", "delete from employee where id = '$id'");
			$i = 0;
			while($i < count($query)){
				mysql_query((string)$query[$i]) or die('BAD QUERY '.mysql_error());
				$i = $i + 1;		
			}
		}
		mysql_free_result($bigresult);
		redirect("All information relating to all employees has been deleted.", $redirect);
	}
	else{
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2>Confirm Deletion of ALL Employees</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
		echo "<tr><td>Please be aware that all office hours, events, seminars, computer labs, research labs, and classes matching ALL employees will be deleted including ALL employees. </td></tr>";
		echo "<tr><td><a href=\"employee_edit.php?mode=delall&c=yes\">Confirm ALL Deletions</a></td></tr>";
		echo "</tbody>";
		echo "</table>";
	}
}
else{
	redirect("ERROR: BAD GET INFO!", $redirect);
}

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
