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

Recreates tables in the database and then repopulates them with data.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php include("create_db.php"); ?>
<?php include("load_db.php"); ?>
<?php
// pops up a javascript message box and then redirects to another page
function redirect($msg, $location){
	echo "<script language=\"javascript\">\n alert(\"".$msg."\"); \n window.location = \"".$location."\"; \n</script>";	
}

redirect("Database restored.", "index.php");
?>
</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
