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

/*
$host="calvados.ucs.louisiana.edu";
$database="cs4601_m";
$user="cs4601m";
$pass="foursixty";
*/
$abspath="/home/jmm0468/cs4601";
$pageroot=".";
$host="localhost";
$database="proj";
$user="root";
$pass="password";

$link = mysql_connect($host, $user, $pass) or die('Error! Could not connect: '.mysql_error());

// Select database
mysql_select_db($database) or die('Cannot select database');
?>
