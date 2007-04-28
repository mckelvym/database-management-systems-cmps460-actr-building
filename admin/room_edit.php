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

Editing of a room. Displays room-type specific forms for each add/edit.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php

// get information for editing or adding
$room = (string)$_GET['room'];
$mode = (string)$_GET['mode'];
$room_type = (string)$_POST['room_type'];
$redirect = "room.php"; // redirect to what page

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

// show edit form for current room, populate some data
if($mode == "edit"){
	// get room types
	$query = "select room_type from room where room_num='$room'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	$tmp_room_type = $row['room_type'];
	
	if($room != ""){
		echo "<table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2 align=center>Edit Room</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
		echo "<FORM method=\"post\" action=\"room_edit.php?mode=do_edit&room=$room&room_type=$tmp_room_type&edit=enabled\">";
		echo "<tr><td>Room Number:</td><td><input disabled type=\"text\" name=\"room\" value=\"$room\" size=\"10\" maxlength=\"4\"></td></tr>";
		echo "<tr><td>Room Type:</td><td><input disabled type=\"text\" name=\"room\" value=\"$tmp_room_type\" size=\"10\" maxlength=\"10\"></td></tr>";
		echo"<tr><td colspan=2 align=center><input type=\"submit\" value=\"Edit Room\"></td></tr>";
		echo"</FORM>";
		echo "</tbody>";
		echo "</table>";		
	}
	else
		redirect("Unknown Error.", $redirect);
}
// got room edit information from form, continue with edit.
else if($mode == "do_edit"){
	$roomtype = $_GET['room_type'];

	// we need special handling for "lab" type rooms, because we have computer labs and research labs
	if($roomtype == "lab"){
		$query = "select count(*) as count from computerlab where room_num = '$room'";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		$count = (int)$row['count'];
		if($count == 1){ $roomtype = "computer lab"; }
		else{ $roomtype = "research lab"; }
	}
	
	// handles all editing/adding
	room_type_handler($room, $roomtype);
}
// remove all occurances of 'room' in each table.
else if($mode == "del"){
	$query = array("delete from events where location = '$room'", "delete from seminar where room_num = '$room'", "delete from classroom where room = '$room'", "delete from office where room = '$room'", "update employee set office_num='' where office_num='$room'", "delete from computerlab where room_num = '$room'", "delete from researchlab where room_num = '$room'", "delete from class where room_num = '$room'", "delete from room where room_num = '$room'");
	$i = 0;
	while($i < count($query)){
		mysql_query((string)$query[$i]) or die('BAD QUERY '.mysql_error());
		$i = $i + 1;		
	}
	redirect("All information relating to the room has been deleted.", $redirect);
}
// remove all rooms and anything depending on them.
else if($mode == "delall"){	
	$query = "select room_num from room";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	while($row = mysql_fetch_assoc($result)){
		$room = $row['room_num'];
		$subquery = array("delete from events where location = '$room'", "delete from seminar where room_num = '$room'", "delete from classroom where room = '$room'", "delete from office where room = '$room'", "update employee set office_num='' where office_num='$room'", "delete from computerlab where room_num = '$room'", "delete from researchlab where room_num = '$room'", "delete from class where room_num = '$room'", "delete from room where room_num = '$room'");
		$i = 0;
		while($i < count($subquery)){
			echo "$i. $query<br/>";
			mysql_query((string)$subquery[$i]) or die('BAD QUERY '.mysql_error());
			$i = $i + 1;
		}
	}
	mysql_free_result($result);
	
	redirect("All rooms and related information has been deleted.", "room.php");
}
//if mode = add display fields to add a room
else if($mode == "add"){
	$room = (string)$_POST['room'];
	
	if($room == "" || $room_type == "" || $room == "0"){
		echo "<table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2 align=center>Add Room</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
		
		// show form
		echo "<FORM method=\"post\" action=\"room_edit.php?mode=add&room=$room\">";
		echo "<tr><td>Room Number:</td><td><input type=\"text\" name=\"room\" value=\"\" size=\"10\" maxlength=\"4\"></td></tr>";
		echo "<tr><td>Room Type:</td><td><select name=\"room_type\">";
			echo "<option value=\"office\">Office</option>";
			echo "<option value=\"lecture\">Lecture</option>";
			echo "<option value=\"research lab\">Research Lab</option>";
			echo "<option value=\"computer lab\">Computer Lab</option>";
			echo "<option value=\"seminar\">Seminar</option>";
			echo "<option value=\"other\">Other</option>";
		echo "</select></td></tr>";
		
		echo"<tr><td colspan=2 align=center><input type=\"submit\" value=\"Submit\"></td></tr>";
		echo"</FORM>";
		echo "</tbody>";
		echo "</table>";
	}
	else if($room != "" && $room_type != "" && $room != "0"){
		
		//checks for occurances of room in row
		//if found $count = 1, if not $count = 0
		$query = "select count(*) as count from room where room_num='$room'";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$row = mysql_fetch_assoc($result);
		$count = (int)$row['count'];
		mysql_free_result($result);
		
		if($count == 0){
			room_type_handler($room, $room_type);
		}
		else
			redirect("Duplicate room number! Try again.", "room_edit.php?mode=add&room=0");
	}
}
else{
	// room handler leads us here
	if($mode == "addlecture"){ addLecture($room); }
	else if($mode == "addclab"){addComputerLab($room); }
	else if($mode == "addrlab"){ addResearchLab($room); }
	else if($mode == "addoffice"){ addOffice($room); }
	else if($mode == "editlecture"){ editLecture($room); }
	else if($mode == "editclab"){ editComputerLab($room); }
	else if($mode == "editrlab"){ editResearchLab($room); }
	else{ redirect("Unknown Error.", $redirect); }
}

// handles editing/adding of rooms, calls specific functions based on type
function room_type_handler($room, $roomtype){
	$redirect = "room.php";
	$isEdit = (string)$_GET['edit'];

	// don't allow editing on these rooms
	if($isEdit == "enabled"){
		if($roomtype == "other"){ redirect("No options to edit", $redirect); return; }
		else if($roomtype == "seminar"){ redirect("No options to edit", $redirect); return; }
		else if($roomtype == "office"){ redirect("No options to edit", $redirect); return; }
	}
	// directly add these type of rooms, no other information is needed.
	else{
		if($roomtype == "other"){ addOther($room); return; }
		else if($roomtype == "seminar"){ addSeminar($room); return; }
	}

	// start a form
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";

	// show appropriate header
	if($isEdit == "enabled"){ echo "<td colspan=2 align=center>Edit Room #$room (".ucwords($roomtype).")</td>";}
	else{ echo "<td colspan=2 align=center>Add Room #$room (".ucwords($roomtype).")</td>"; }
	
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";

	// lets go!
	if($roomtype == "lecture"){ formLecture($room, $isEdit); }
	else if($roomtype == "computer lab"){ formComputerLab($room, $isEdit); }
	else if($roomtype == "research lab"){ formResearchLab($room, $isEdit); }
	else if($roomtype == "office"){ formOffice($room); }
	else{
		redirect("There was an error processing the information. Please try again.", $redirect);
	}
	// end form
	echo"<tr><td colspan=2 align=center><input type=\"submit\" value=\"Continue\"></td></tr>";
	echo"</FORM>";
	echo "</tbody>";
	echo "</table>";
}

// inserts a room into the room table
function insertRoom($room){
	$type1 = (string)$_GET['type'];
	$type2 = (string)$_POST['room_type'];
	if($type1 != ""){
		$query = "insert into room values ('$room', '$type1')";
	}
	else if($type1 == "" && $type2 != ""){
		$query = "insert into room values ('$room', '$type2')";	
	}
	else{
		redirect("Encountered a weird error when inserting room.", "room.php");
		return;
	}	
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());	
}

// show a form for lecture rooms
function formLecture($room, $isEdit){
	if($isEdit){ 
		echo "<FORM method=\"post\" action=\"room_edit.php?mode=editlecture&room=$room&type=lecture\">";
		$query = "select num_seats from classroom where room = '$room'";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		$seats = (int)$row['num_seats'];
	}
	else{ echo "<FORM method=\"post\" action=\"room_edit.php?mode=addlecture&room=$room&type=lecture\">"; }
	echo "<tr><td>Room Number:</td><td><input disabled type=\"text\" name=\"room\" value=\"$room\" size=\"10\" maxlength=\"4\"></td></tr>";		
	echo "<tr><td>Number of Seats:</td><td><select name=\"num_seats\">";
		$i = 10;
		while($i <= 200){
			if($seats == $i){ echo "<option selected value=\"$i\">$i Seats</option>"; }
			else{ echo "<option value=\"$i\">$i Seats</option>"; }
			$i = $i + 1;
		}
	echo "</select></td></tr>";
}

// adds a lecture room to the right table(s)
function addLecture($room){
	$seats = (string)$_POST['num_seats'];
	insertRoom($room);
	$query = "insert into classroom values ('$room', '$seats')";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Done adding lecture room.", "room.php");
}

// updates a lecture room to the right table(s)
function editLecture($room){
	$seats = (string)$_POST['num_seats'];
	$query = "update classroom set num_seats = '$seats' where room = '$room'";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Done editing lecture room.", "room.php");
}

// shows a form for a computer lab
function formComputerLab($room, $isEdit){
	if($isEdit){ echo "<FORM method=\"post\" action=\"room_edit.php?mode=editclab&room=$room&type=lab\">"; }
	else{ echo "<FORM method=\"post\" action=\"room_edit.php?mode=addclab&room=$room&type=lab\">"; }
	echo "<tr><td>Room Number:</td><td><input disabled type=\"text\" name=\"room\" value=\"$room\" size=\"10\" maxlength=\"4\"></td></tr>";		
	echo "<tr><td>Number of Computers:</td><td><select name=\"num_computers\">";
		$i = 2;
		echo "<option value=\"1\">1 Computer</option>";
		while($i <= 50){
			echo "<option value=\"$i\">$i Computers</option>";
			$i = $i + 1;
		}
	echo "</select></td></tr>";
	echo "<tr><td>OS on Computers:</td><td><select name=\"type_computers\">";
		echo "<option value=\"linux\">Linux</option>";			
		echo "<option value=\"unix\">Unix</option>";			
		echo "<option value=\"windows\">Windows</option>";			
		echo "<option value=\"mac\">Mac</option>";			
		echo "<option value=\"dual\">Dual Boot</option>";			
		echo "<option value=\"other\">Other</option>";			
	echo "</select></td></tr>";
	echo "<tr><td>Hours of Operation</td><td>";
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
	echo "<tr><td>Days Open: </td><td>";
		echo "<input checked type=checkbox value=m name=d1> Monday<br/>";
		echo "<input checked type=checkbox value=t name=d2> Tuesday<br/>";
		echo "<input checked type=checkbox value=w name=d3> Wednesday<br/>";
		echo "<input checked type=checkbox value=r name=d4> Thursday<br/>";
		echo "<input checked type=checkbox value=f name=d5> Friday<br/>";
		echo "<input type=checkbox value=s name=d6> Saturday<br/>";
		echo "<input type=checkbox value=u name=d7> Sunday<br/>";
		echo "</td></tr>";
	echo "<tr><td>Purpose:</td><td><input type=\"text\" name=\"purpose\" value=\"\" size=\"50\" maxlength=\"50\"></td></tr>";		
}

// adds a computer lab to the right table(s)
function addComputerLab($room){
	$num_computers = (string)$_POST['num_computers'];
	$type_computers = (string)$_POST['type_computers'];
	$contact = (string)$_POST['contact'];
	$hours = $_POST['stime'].$_POST['stimep']."-".$_POST['etime'].$_POST['etimep'];
	$days = (string)$_POST['d1'].$_POST['d2'].$_POST['d3'].$_POST['d4'].$_POST['d5'].$_POST['d6'].$_POST['d7'];
	$purpose = (string)$_POST['purpose'];
	insertRoom($room);
	$query = "insert into computerlab values ('$room', '$num_computers', '$type_computers', '$contact', '$hours', '$days', '$purpose')";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Done adding computer lab.", "room.php");
}

// updates a computer lab o the right table(s)
function editComputerLab($room){
	$num_computers = (string)$_POST['num_computers'];
	$type_computers = (string)$_POST['type_computers'];
	$contact = (string)$_POST['contact'];
	$hours = $_POST['stime'].$_POST['stimep']."-".$_POST['etime'].$_POST['etimep'];
	$days = (string)$_POST['d1'].$_POST['d2'].$_POST['d3'].$_POST['d4'].$_POST['d5'].$_POST['d6'].$_POST['d7'];
	$purpose = (string)$_POST['purpose'];
	$query = "update computerlab set num_computers = '$num_computers', type_computers = '$type_computers', contact_id = '$contact', hours = '$hours', days = '$days', purpose = '$purpose' where room_num = '$room'";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Done editing computer lab.", "room.php");
}

// form for a research lab
function formResearchLab($room, $isEdit){
	if($isEdit){ echo "<FORM method=\"post\" action=\"room_edit.php?mode=editrlab&room=$room&type=lab\">"; }
	else{ echo "<FORM method=\"post\" action=\"room_edit.php?mode=addrlab&room=$room&type=lab\">"; }	
	echo "<tr><td>Room Number:</td><td><input disabled type=\"text\" name=\"room\" value=\"$room\" size=\"10\" maxlength=\"4\"></td></tr>";		
	echo "<tr><td>Hours of Operation</td><td>";
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
	echo "<tr><td>Days Open: </td><td>";
		echo "<input checked type=checkbox value=m name=d1> Monday<br/>";
		echo "<input checked type=checkbox value=t name=d2> Tuesday<br/>";
		echo "<input checked type=checkbox value=w name=d3> Wednesday<br/>";
		echo "<input checked type=checkbox value=r name=d4> Thursday<br/>";
		echo "<input checked type=checkbox value=f name=d5> Friday<br/>";
		echo "<input type=checkbox value=s name=d6> Saturday<br/>";
		echo "<input type=checkbox value=u name=d7> Sunday<br/>";
		echo "</td></tr>";
	echo "<tr><td>Purpose:</td><td><input type=\"text\" name=\"purpose\" value=\"\" size=\"50\" maxlength=\"50\"></td></tr>";		
}

// adds a research lab into the right table(s)
function addResearchLab($room){
	$contact = (string)$_POST['contact'];
	$hours = $_POST['stime'].$_POST['stimep']."-".$_POST['etime'].$_POST['etimep'];
	$days = (string)$_POST['d1'].$_POST['d2'].$_POST['d3'].$_POST['d4'].$_POST['d5'].$_POST['d6'].$_POST['d7'];
	$purpose = (string)$_POST['purpose'];
	insertRoom($room);
	$query = "insert into researchlab values ('$room', '$contact', '$hours', '$days', '$purpose')";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Done adding research lab.", "room.php");
}

// edits a research lab by updating the right table(s)
function editResearchLab($room){
	$contact = (string)$_POST['contact'];
	$hours = $_POST['stime'].$_POST['stimep']."-".$_POST['etime'].$_POST['etimep'];
	$days = (string)$_POST['d1'].$_POST['d2'].$_POST['d3'].$_POST['d4'].$_POST['d5'].$_POST['d6'].$_POST['d7'];
	$purpose = (string)$_POST['purpose'];
	$query = "update researchlab set contact_id = '$contact', hours = '$hours', days = '$days', purpose = '$purpose' where room_num = '$room'";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Done editing research lab.", "room.php");
}

// shows a form for an office
function formOffice($room){
	echo "<FORM method=\"post\" action=\"room_edit.php?mode=addoffice&room=$room&type=office\">";
	echo "<tr><td>Room Number:</td><td><input disabled type=\"text\" name=\"room\" value=\"$room\" size=\"10\" maxlength=\"4\"></td></tr>";		
	echo "<tr><td>Occupant</td><td>";
		echo "<select name=\"occupant_id\">";
		echo "<option value=unoccupied>Unoccupied</option>";
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
}

// adds an office to the right table(s)
function addOffice($room){
	$occupant = (string)$_POST['occupant_id'];
	insertRoom($room);
	$query = "insert into office values ('$room', '$occupant')";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Done adding office.", "room.php");
}

// directly adds a seminar room
function addSeminar($room){
	insertRoom($room);
	redirect("Done adding seminar room.", "room.php");
}

// directly adds an 'other' type room
function addOther($room){
	insertRoom($room);
	redirect("Done adding room.", "room.php");
}

?>
</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
