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
$query = "show tables";
$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

echo "<table class=\"default\">";

// field headers
echo "<thead class=\"default\"><tr><td>Dropped Tables</td></tr></thead>";
echo "<tbody class=\"default\">";


$j = 0;
while($j < mysql_num_rows($result)){
	$table = mysql_fetch_assoc($result);
	$column = "Tables_in_$database";
	if($table[$column] != "admin"){
		$query2 = "drop table ".$table[$column];
		$result2 = mysql_query((string)$query2) or die('BAD QUERY '.mysql_error());
		echo "<tr><td>Dropped table: ".$table['Tables_in_proj']."</td></tr>";
	}
	$j = $j + 1;
}
echo "</tbody></table>";
mysql_free_result($result);

?>
</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
