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

Shows all courses and related information
-->
<?php include("../header.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php
// grab information about every course.
$query = "select course_num, title, dept, credit from course order by course_num, dept, credit, title";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=10 align=center>All Courses</td></tr></thead>";	
echo "<thead class=\"default\">";
echo "<tr><td>Course Num</td><td>Title</td><td>Department</td><td>Credit Hours</td></tr></thead>";	

echo "<tbody class=\"default\">";

// output to a table
while($row = mysql_fetch_assoc($result)){	
	$course_num = $row['course_num'];
	$title = $row['title'];
	$dept = $row['dept'];
	$credit = $row['credit'];
	echo "<tr>";
	echo "<td align=center>$course_num</td>";
	echo "<td>$title</td>";
	echo "<td align=center>$dept</td>";
	echo "<td align=center>$credit</td>";
	echo "</tr>";
}
echo "</td></tbody></table>";
mysql_free_result($result);

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
