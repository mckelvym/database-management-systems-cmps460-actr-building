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

Clears the session for the user and effectively logs them out.
*/
?>
<?php

session_start();
$_SESSION['Login']="";
// clear the session
unset($_SESSION['Login']); 
session_destroy();
header( 'Location: login.php' ) ;
?>
