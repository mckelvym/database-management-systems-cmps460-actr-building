<!-- 
Authors:
James McKelvy (jmm0468)
Gavin Choate (gdc0730)
Jed Ancona (jca8822)

CMPS460
Database Project
April 27, 2007

~~~ CERTIFICATION OF AUTHENTICITY ~~~
The code contained within this script is the combined work of the above mentioned authors.

Index page that includes links to other useful pages including admin login link.
-->
<?php include("../header.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php 

// show table
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td>Options</td></tr></thead>";	
echo "<tbody class=\"default\">";
echo "<tr><td><a href=\"../admin\">Admin Home</a></td></tr>";
echo "<tr><td><a href=\"employee.php?pageid=2\">View Employees</a></td></tr>";
echo "<tr><td><a href=\"room.php?pageid=3\">View Rooms</a></td></tr>";
echo "<tr><td><a href=\"classschedule.php?pageid=4\">View Schedule of Classes</a></td></tr>";
echo "<tr><td><a href=\"events.php?pageid=5\">View Events</a></td></tr>";
echo "<tr><td><a href=\"showseminars.php?pageid=5\">Show all Seminars</a></td></tr>";
echo "<tr><td><a href=\"showclasses.php?pageid=4\">Show all Classes</a></td></tr>";
echo "<tr><td><a href=\"showcourses.php?pageid=4\">Show all Courses</a></td></tr>";
echo "<tr><td><a href=\"showofficehours.php?pageid=2\">Show all Office Hours</a></td></tr>";
echo "</tbody></table>";
?>
</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
