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

Shows types of rooms and forwards to a roominfo page.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php
$query = "select room_num,room_type from room order by room_type,room_num";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

// begin table
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=3>Room Management</td></tr></thead>";	
echo "<tbody class=\"default\">";
echo "<tr><td><a href=\"room_edit.php?room=0&mode=delall\">Delete All</a></td><td><a href=\"room_edit.php?room=0&mode=add\">Add</a></tr>\n";
echo "</tbody></table>";

echo "<br/>";

echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td>All Rooms</td></tr></thead>";	
echo "<tbody class=\"default\"><tr><td>";
echo "<form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Room</option>";

// main dropdown
while($row = mysql_fetch_assoc($result)){	
	$room = $row['room_num'];
	$type = $row['room_type'];
	echo "<option value=\"roominfo.php?room=$room&type=$type\">Room $room, ".ucwords($type)."</option>\n";	
}
echo "</select></form>";
echo "</td></tr></tbody></table>";
mysql_free_result($result);

echo "<br/>";

echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=5 align=center>Types of Rooms</td></tr></thead>";	
echo "<thead class=\"default\">";
echo "<tr><td>Computer Labs</td><td>Research Labs</td><td>Classrooms</td><td>Offices</td><td>Seminar Rooms</td></tr></thead>";	
echo "<tbody class=\"default\">";
echo "<tr>";

// dropdown for computerlabs
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Computer Lab</option>";
$query = "select r.room_num from room r, computerlab l where r.room_num = l.room_num";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$room = $row['room_num'];
	echo "<option value=\"roominfo.php?room=$room&type=lab\">Room $room</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);

// dropdown for researchlabs
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Research Lab</option>";
$query = "select r.room_num from room r, researchlab l where r.room_num = l.room_num";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$room = $row['room_num'];
	echo "<option value=\"roominfo.php?room=$room&type=lab\">Room $room</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);

// dropdown for classrooms
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Classroom</option>";
$query = "select room_num from room where room_type = 'lecture' order by room_num";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$room = $row['room_num'];
	echo "<option value=\"roominfo.php?room=$room&type=lecture\">Room $room</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);

// dropdown for offices
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Office</option>";
$query = "select room_num from room where room_type = 'office' order by room_num";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$room = $row['room_num'];
	echo "<option value=\"roominfo.php?room=$room&type=office\">Room $room</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);

// dropdown for seminar rooms
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Seminar Room</option>";
$query = "select room_num from room where room_type = 'seminar' order by room_num";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$room = $row['room_num'];
	echo "<option value=\"roominfo.php?room=$room&type=seminar\">Room $room</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);

echo "</tr>";
echo "</tbody></table>";

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
