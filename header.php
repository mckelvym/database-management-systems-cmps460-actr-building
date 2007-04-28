<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
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
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>CMPS460DB_project_09 F9 11 02 9D 74 E3 5B D8 41 56 C5 63 56 88 C0</title>
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
<?php 
$pageid = (string)$_GET['pageid'];

if($pageid == "" || $pageid == 0){
?>
					<li><a class="activeTab" href="../scripts/index.php?pageid=1">User Home</a></li>
					<li><a class="inactiveTab" href="../admin?pageid=0">Admin Home</a></li>
					<li><a class="inactiveTab" href="../scripts/employee.php?pageid=2">Employees</a></li>
					<li><a class="inactiveTab" href="../scripts/room.php?pageid=3">Rooms</a></li>
					<li><a class="inactiveTab" href="../scripts/classschedule.php?pageid=4">Classes</a></li>
					<li><a class="inactiveTab" href="../scripts/events.php?pageid=5">Events</a></li>
<?php
}
if($pageid == 1){
?>
					<li><a class="activeTab" href="index.php?pageid=1">User Home</a></li>
					<li><a class="inactiveTab" href="../admin?pageid=0">Admin Home</a></li>
					<li><a class="inactiveTab" href="employee.php?pageid=2">Employees</a></li>
					<li><a class="inactiveTab" href="room.php?pageid=3">Rooms</a></li>
					<li><a class="inactiveTab" href="classschedule.php?pageid=4">Classes</a></li>
					<li><a class="inactiveTab" href="events.php?pageid=5">Events</a></li>
<?php
}
if($pageid == 2){
?>
					<li><a class="inactiveTab" href="index.php?pageid=1">User Home</a></li>
					<li><a class="inactiveTab" href="../admin?pageid=0">Admin Home</a></li>
					<li><a class="activeTab" href="employee.php?pageid=2">Employees</a></li>
					<li><a class="inactiveTab" href="room.php?pageid=3">Rooms</a></li>
					<li><a class="inactiveTab" href="classschedule.php?pageid=4">Classes</a></li>
					<li><a class="inactiveTab" href="events.php?pageid=5">Events</a></li>
<?php
}if($pageid == 3){
?>
					<li><a class="inactiveTab" href="index.php?pageid=1">User Home</a></li>
					<li><a class="inactiveTab" href="../admin?pageid=0">Admin Home</a></li>
					<li><a class="inactiveTab" href="employee.php?pageid=2">Employees</a></li>
					<li><a class="activeTab" href="room.php?pageid=3">Rooms</a></li>
					<li><a class="inactiveTab" href="classschedule.php?pageid=4">Classes</a></li>
					<li><a class="inactiveTab" href="events.php?pageid=5">Events</a></li>
<?php
}if($pageid == 4){
?>
					<li><a class="inactiveTab" href="index.php?pageid=1">User Home</a></li>
					<li><a class="inactiveTab" href="../admin?pageid=0">Admin Home</a></li>
					<li><a class="inactiveTab" href="employee.php?pageid=2">Employees</a></li>
					<li><a class="inactiveTab" href="room.php?pageid=3">Rooms</a></li>
					<li><a class="activeTab" href="classschedule.php?pageid=4">Classes</a></li>
					<li><a class="inactiveTab" href="events.php?pageid=5">Events</a></li>
<?php
}if($pageid == 5){
?>
					<li><a class="inactiveTab" href="index.php?pageid=1">User Home</a></li>
					<li><a class="inactiveTab" href="../admin?pageid=0">Admin Home</a></li>
					<li><a class="inactiveTab" href="employee.php?pageid=2">Employees</a></li>
					<li><a class="inactiveTab" href="room.php?pageid=3">Rooms</a></li>
					<li><a class="inactiveTab" href="classschedule.php?pageid=4">Classes</a></li>
					<li><a class="activeTab" href="events.php?pageid=5">Events</a></li>
<?php
}

?>
					
				</ul>
				</div>
				<div id="rightCap"></div>
			</div>
			<!-- <div id="goForward"><a href="" onClick="history.go(1);"><img src="../images/forward.jpg" border=0></a></div> -->
			<!-- <div id="goBack"><a href="" onClick="history.go(-1);"><img src="../images/back.jpg" border=0></a></div> -->

