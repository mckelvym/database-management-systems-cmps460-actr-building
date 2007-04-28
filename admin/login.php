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

This is the login form on the admin side. If the user is logged in, they are forwarded to index.php.
If not, they are required to log in before continuing.
*/

// set the session
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php include("../connect.php"); ?>
<?php
// get post information on mode
$mode_info = (string)$_GET['mode'];

if($mode_info == 'login')
{

	// grab the user name and password from the submit form
	$user_post = $_POST['username'];
	$pass_post = $_POST['password'];
	$query = "select * from admin";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());

	// check all usernames and passwords for a match
	while($row = mysql_fetch_assoc($result)){

		$user=$row['user_name'];
	        $pass=$row['password'];
		// allow proceed if match found
	        if($user_post == $user && $pass_post == $pass){
			$_SESSION['Login'] = 'Yes';
//			header( 'Location: index.php' ) ;
			?>
			<script language="javascript">
			window.location = "index.php";
			</script>
			<?php
	        }
    }
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>CMPS460_DB_project_AdminLogin</title>
<!--		<link href="../layout.css" rel="stylesheet" type="text/css" /> -->
<style type="text/css">
<?php include("../layout.css"); ?>
</style>
</head>
<body>
<div id="container">
<img id="logo" src="../images/actr.jpg" />
<div id="navbar">
<div id="leftCap"></div>
<div id="navLinks">
<ul>
<li><a class="inactiveTab" href="../scripts/index.php?pageid=1">User Home</a></li>
<li><a class="activeTab" href="../admin/index.php?pageid=0">Admin Home</a></li>
<li><a class="inactiveTab" href="../scripts/employee.php?pageid=2">Employees</a></li>
<li><a class="inactiveTab" href="../scripts/room.php?pageid=3">Rooms</a></li>
<li><a class="inactiveTab" href="../scripts/classschedule.php?pageid=4">Classes</a></li>
<li><a class="inactiveTab" href="../scripts/events.php?pageid=5">Events</a></li></ul>
</div>
<div id="rightCap"></div>
</div>
<div id="content">
<table align=center>
    <form action="login.php?mode=login" method="post">
    <tr><td style="padding:4px">User Name: </td><td> <input name=username id=username type=text value=""></td></tr>
    <tr><td style="padding:4px">Password: </td><td> <input name=password id=password type=password value=""></td></tr>
<tr><td></td><td align=right><input type=submit value=Login></td></tr>
</table>
</div>
<div id="aboutus" align=center><a href="../aboutus">About Us</a></div>
</div>
</body>
</html>

<?php include("../close.php"); ?>
