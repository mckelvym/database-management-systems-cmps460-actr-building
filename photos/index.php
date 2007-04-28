<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
		
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>CMPS460_DB_project</title>
<style type="text/css">
<?php include("../layout.css"); ?>
</style>

	</head>
	<body>
		<div id="container">
			
<div id="content">

<?php
$lsarray=explode("\n", `ls .`);

echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=2>Current Images</td></tr></thead>";	
echo "<tbody class=\"default\">";

foreach($lsarray as $dir){
	if($dir != "index.php"){
		echo "<tr><td>$dir</td><td><img src=\"$dir\" width=200></td></tr>";
	}
}
echo "</tbody></table>";

?>


</div>
<?php include("../footer.php"); ?>
