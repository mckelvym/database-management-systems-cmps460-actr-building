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

About us.
-->
<?php include("../header.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php 

// show table
echo "<table class=\"default\">";
echo "<thead class=\"default\">";
echo "<tr><td colspan=3>This is all you need to know</td></tr></thead>";	
echo "<tbody class=\"default\"><tr>";
echo "<td><img width=200 src='gavin.jpg'></td>";
echo "<td><img width=200 src='mark.jpg'></td>";
echo "<td><img width=200 src='jed.jpg'></td>";
echo "</tr></tbody></table>";
?>
</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
