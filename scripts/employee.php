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

This is to show all employees and includes dropdowns for specific employee types.
-->
<?php include("../header.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php
// get all employees, main dropdown
$query = "select id,lastname,firstname,position from employee order by position,lastname,firstname";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=3>All Employees</td></tr></thead>";	
echo "<tbody class=\"default\"><tr><td>";

echo "<form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Employee</option>";
while($row = mysql_fetch_assoc($result)){	
	$id = $row['id'];
	$last = $row['lastname'];
	$first = $row['firstname'];
	$pos = $row['position'];
	echo "<option value=\"employeeinfo.php?pageid=2&id=$id\">$first $last (".ucwords($pos).")</option>\n";
}
echo "</select></form>";
echo "</td></tr></tbody></table>";
mysql_free_result($result);




echo "<br/>";

echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=5 align=center>Types of Employees</td></tr></thead>";	
echo "<thead class=\"default\">";
echo "<tr><td>Faculty</td><td>Graders</td><td>Research Assistants</td><td>Teaching Assistants</td><td>Secretaries</td></tr></thead>";	
echo "<tbody class=\"default\">";
echo "<tr>";

// dropdown for faculty
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Faculty</option>";
$query = "select id,lastname,firstname from employee where position = 'faculty' order by lastname,firstname";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$id = $row['id'];
	$last = $row['lastname'];
	$first = $row['firstname'];
	echo "<option value=\"employeeinfo.php?pageid=2&id=$id\">$first $last</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);

// dropdown for graders
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Grader</option>";
$query = "select id,lastname,firstname from employee where position = 'grader' order by lastname,firstname";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$id = $row['id'];
	$last = $row['lastname'];
	$first = $row['firstname'];
	echo "<option value=\"employeeinfo.php?pageid=2&id=$id\">$first $last</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);

// dropdown for research assistants
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select RA</option>";
$query = "select id,lastname,firstname from employee where position = 'research assistant' order by lastname,firstname";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$id = $row['id'];
	$last = $row['lastname'];
	$first = $row['firstname'];
	echo "<option value=\"employeeinfo.php?pageid=2&id=$id\">$first $last</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);

// dropdown for teaching assistants
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select TA</option>";
$query = "select id,lastname,firstname from employee where position = 'teaching assistant' order by lastname,firstname";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$id = $row['id'];
	$last = $row['lastname'];
	$first = $row['firstname'];
	echo "<option value=\"employeeinfo.php?pageid=2&id=$id\">$first $last</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);


// dropdown for secretaries
echo "<td><form><select onchange=\"if((w=this.options[this.selectedIndex].value)!='') window.location=w\">\n";
echo "<option value=\"#\" >Select Secretary</option>";
$query = "select id,lastname,firstname from employee where position = 'secretary' order by lastname,firstname";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
while($row = mysql_fetch_assoc($result)){	
	$id = $row['id'];
	$last = $row['lastname'];
	$first = $row['firstname'];
	echo "<option value=\"employeeinfo.php?pageid=2&id=$id\">$first $last</option>\n";	
}
echo "</select></form></td>";
mysql_free_result($result);

echo "</tr>";
echo "</tbody></table>";

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
