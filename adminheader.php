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
?><?php
session_start();
if($_SESSION['Login'] != 'Yes'){
      header( 'Location: login.php' ) ;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
		
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>CMPS460_DB_project Admin</title>
<!--		<link href="../layout.css" rel="stylesheet" type="text/css" /> -->
<style type="text/css">
<?php include("layout.css"); ?>
</style>

	</head>
	<body>
		<div id="container">
			<!-- <div id="navigation"><a href=\"javascript:history.go(-1)\"><img border=0 src="../images/bk.jpg"</a> <a href=\"javascript:history.go(1)\"><img border=0 src="../images/fw.jpg"</a></div> -->
			<img id="logo" src="../images/actr.jpg" />
			<div id="navbar">
				<div id="leftCap"></div>
				<div id="navLinks">
				<ul>
					<li><a class="inactiveTab" href="../scripts/index.php">User Home</a></li>
					<li><a class="inactiveTab" href="index.php">Admin Home</a></li>
					<li><a class="inactiveTab" href="employee.php">Employees</a></li>
					<li><a class="inactiveTab" href="room.php">Rooms</a></li>
					<li><a class="inactiveTab" href="classschedule.php">Classes</a></li>
					<li><a class="inactiveTab" href="events.php">Events</a></li>
					<li><a class="inactiveTab" href="logout.php">Logout</a></li>
				</ul>
				</div>
				<div id="rightCap"></div>
			</div>
