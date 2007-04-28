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

Allows putting in queries view web browser and getting results of select statements.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php
$post_info = (string)$_POST['query'];

// pops up a javascript message box
function popup($msg){
	echo "<script language=\"javascript\">\n alert(\"".$msg."\"); \n </script>";	
}
?>	

Leave blank to show tables and column information.
<FORM method="post" action="viewquery.php">
Query: <br><textarea name="query" cols=100 rows=10><?php 
$post_info = str_replace("\'", "'", $post_info);
echo $post_info;
?></textarea>
<br><input type="submit" value="Query It">
</FORM>

<?php

$tmp = explode("admin", $post_info);
if($post_info != "" && count($tmp) == 1){
	$query = $post_info;
	$tables=false;
}
else if(count($tmp) != 1){
	popup("Not allowed to view this table");
	$query = "show tables";
	$tables=true;
}
else{
	$query = "show tables";
	$tables=true;
}

$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

echo "<table class=\"default\">";

// field headers
echo "<thead class=\"default\"><tr>";
for ($i=0; $i < mysql_num_fields($result); $i++){
	$field_name = mysql_field_name($result, $i);
	echo "<td>[$field_name]</td>";
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
		if($tables){
			$query2 = "select * from ".$row["$field_name"];
			$result2 = mysql_query((string)$query2) or die('BAD QUERY '.mysql_error());
			for($rowId=0; $rowId < mysql_num_fields($result2); $rowId++){
				$field_name2 = mysql_field_name($result2, $rowId);
				echo "<td>[$field_name2]</td>";		

			}			
		}
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
