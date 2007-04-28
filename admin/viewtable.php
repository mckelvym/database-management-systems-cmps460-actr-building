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

Shows all tables in the database and the user can view the information in those tables.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php
$post_info = (string)$_POST['name'];

// pops up a javascript message box
function popup($msg){
	echo "<script language=\"javascript\">\n alert(\"".$msg."\"); \n </script>";	
}
?>	

Leave blank to show tables. Put a table name to see data.
<FORM method="post" action="viewtable.php">
Table Name: <input type="text" name="name" value="" size="50" maxlength="50">
<br><input type="submit" value="Query It">
</FORM>

<?php
if($post_info != "" && $post_info != "admin"){
	$query = "select * from $post_info";
}
else if($post_info == "admin"){
	popup("Not allowed to view this table");
	$query = "show tables";
}
else{
	$query = "show tables";
}

$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

echo "<table class=\"default\">";

// field headers
echo "<thead class=\"default\"><tr>";
for ($i=0; $i < mysql_num_fields($result); $i++){
	$field_name = mysql_field_name($result, $i);
	echo "<td>$field_name</td>";
}
echo "</tr></thead>";

echo "<tbody class=\"default\">";

$j = 0;
while($j < mysql_num_rows($result)){
	$row = mysql_fetch_assoc($result);
	echo "<tr>";
	for ($i=0; $i < mysql_num_fields($result); $i++){
		$field_name = mysql_field_name($result, $i);
		echo "<td>".$row["$field_name"]."</td>";
	}
	echo "</tr>";
	$j = $j + 1;
}

echo "</tbody>";
echo "</table>";
mysql_free_result($result);

?>
</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
