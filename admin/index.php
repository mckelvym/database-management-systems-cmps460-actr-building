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


	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td colspan=2 align=center>Options</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	echo "<tr><td><a href=\"../scripts\">User Home</a></td></tr>";
	echo "<tr><td><a href=\"../docs/userguide.pdf\">Admin's User Guide (PDF)</a></td></tr>";
	echo " <tr><td><a href=\"login_edit.php\">User Login Administration</a></td></tr>";
	echo "<tr><td><a href=\"showofficehours.php\">View Office Hours</a></td></tr>";
	echo "<tr><td><a href=\"showclasses.php\">View all Classes</a></td></tr>";
	echo "<tr><td><a href=\"employee.php\">View/Edit Employees</a></td></tr>";
	echo "<tr><td><a href=\"room.php\">View/Edit Rooms</a></td></tr>";
	echo "<tr><td><a href=\"classschedule.php\">View/Edit Schedule of Classes</a></td></tr>";
	echo "<tr><td><a href=\"events.php\">View/Edit Events</a></td></tr>";
	echo "<tr><td><a href=\"showcourses_edit.php\">View/Edit Courses</a></td></tr>";
	echo "<tr><td><a href=\"showseminars_edit.php\">View/Edit Seminars</a></td></tr>";
	echo " <tr><td><a href=\"viewtable.php\">View Tables</a></td></tr>";
	echo " <tr><td><a href=\"viewquery.php\">Make Queries</a></td></tr>";
	echo " <tr><td><a href=\"delete_db.php\">Delete all tables from database</a></td></tr>";
	echo " <tr><td><a href=\"delete_data.php\">Delete all data from database</a></td></tr>";
	echo " <tr><td><a href=\"reload_db.php\">Reload all tables & data in db</a></td></tr>";
	echo "<tr><td><a href=\"../aboutus\">About Us</a></td></tr>";
	echo "</tbody>";
	echo "</table>";

?>
</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
