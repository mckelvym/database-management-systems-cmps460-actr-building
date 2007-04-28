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

This script is for editing user logins into the admin side of the software.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php

// Getting information from submitted forms and/or previous pages
$user = (string)$_GET['u'];
$post_user = (string)$_POST['user'];
$pass1 = (string)$_POST['pass1'];
$pass2 = (string)$_POST['pass2'];
$mode = (string)$_GET['mode'];

// Begin table
echo "<table class=\"default\">";
echo "<thead class=\"default\"><tr>";
echo "<td colspan=4>User Login Administration</td>";
echo "</tr></thead>";
echo "<tbody class=\"default\">";
echo "<tr>";
echo "<td><a href=\"login_edit.php?mode=add\">Add New User</a></td>";
echo "<td><a href=\"login_edit.php?mode=view\">View Users</a></td>";
echo "</tr>";
echo "</tbody>";
echo "</table>";

// Area to add a new user
if($mode == "add"){
	
	// User hasn't filled out password fields, show table.
	if($pass1 == "" || $pass2 == "" || $post_user == ""){
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2>Add New User</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
				
		echo "<FORM method=\"post\" action=\"login_edit.php?mode=add\">";
	 	echo "<tr><td>User:</td><td><input type=\"text\" name=\"user\" size=\"20\" maxlength=\"50\"></td></tr>";
		echo "<tr><td>Password:</td><td><input type=\"password\" name=\"pass1\" size=\"20\" maxlength=\"50\"></td></tr>";
		echo "<tr><td>Retype:</td><td><input type=\"password\" name=\"pass2\" size=\"20\" maxlength=\"50\"></td></tr>";
		echo "<tr><td colspan=2 align=center><input type=\"submit\" value=\"Add\"></td></tr>";
		echo "</FORM>";
		echo "</tbody>";
		echo "</table>";

	}
	// passwords don't match
	else if($pass1 != $pass2){
		echo "<script language=\"javascript\">\n alert(\"Passwords do not match!\"); \n</script>";	
	}
	// everything is ok, proceed with add
	else if($pass1 == $pass2 && $post_user != ""){
		$query = "select count(*) as count from admin";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$row = mysql_fetch_assoc($result);
		$increment = (int)$row['count'] + 1;
		mysql_free_result($result);
		$query = "insert into admin values ($increment, \"$post_user\", \"$pass1\")";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		echo "<script language=\"javascript\">\n alert(\"User added successfully.\"); \n window.location = \"login_edit.php\";\n</script>";	

	}
}
// view current users on the system
else if($mode == "view"){	
	
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\"><tr>";
	echo "<td colspan=3>Users</td>";
	echo "</tr></thead>";
	echo "<tbody class=\"default\">";
	
	$query = "select user_name from admin";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	while($row = mysql_fetch_assoc($result)){
		$username = $row['user_name'];
		echo "<tr><td>$username</td><td><a href=\"login_edit.php?mode=edit&u=$username\">Edit Password</a></td><td><a href=\"login_edit.php?mode=delete&u=$username\">Delete</a></td></tr>";
	
	}
	mysql_free_result($result);
	echo "</tbody>";
	echo "</table>";	
}
// edit current users on the system
else if($mode == "edit"){
	$query = "select password from admin where user_name = '$user'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result);
	$old_pass2 = $row['password'];

	mysql_free_result($result);
	$old_pass = (string)$_POST['oldpass'];

	// show edit form
	if($pass1 == "" || $pass2 == "" || $user == "" || $old_pass == ""){
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2>Edit User: $user</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
				
		echo "<FORM method=\"post\" action=\"login_edit.php?mode=edit&u=$user\">";
	 	echo "<tr><td>Old Password:</td><td><input type=\"password\" name=\"oldpass\" size=\"20\" maxlength=\"50\"></td></tr>";
		echo "<tr><td>New Password:</td><td><input type=\"password\" name=\"pass1\" size=\"20\" maxlength=\"50\"></td></tr>";
		echo "<tr><td>Retype:</td><td><input type=\"password\" name=\"pass2\" size=\"20\" maxlength=\"50\"></td></tr>";
		echo "<tr><td colspan=2 align=center><input type=\"submit\" value=\"Submit Changes\"></td></tr>";
		echo "</FORM>";
		echo "</tbody>";
		echo "</table>";
	}
	// passwords don't match, redirect
	else if($pass1 != $pass2){
		echo "<script language=\"javascript\">\n alert(\"Passwords do not match!\"); \n window.location = \"login_edit.php\"; \n</script>";	
	}
	// old password is incorrect 
	else if($old_pass != $old_pass2){
		echo "<script language=\"javascript\">\n alert(\"Password does not match that of database!\"); \n window.location = \"login_edit.php\"; \n</script>";	
	}
	// everything is ok, proceed as normal
	else if($pass1 == $pass2 && $user != "" && $old_pass == $old_pass2){
		$query = "update admin set password = '$pass1' where user_name = '$user'";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		mysql_free_result($result);
		echo "<script language=\"javascript\">\n alert(\"User edited successfully.\"); \n window.location = \"login_edit.php\";\n</script>";	
	}	
}
// delete user from system
else if($mode == "delete"){
	$query = "delete from admin where user_name = '$user'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	echo "<script language=\"javascript\">\n alert(\"Successful deletion.\"); \n window.location = \"login_edit.php\";\n</script>";	
}
?>
</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
