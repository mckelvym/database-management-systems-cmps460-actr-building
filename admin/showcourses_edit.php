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

Shows all course and allows editing/adding/deleting.
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">

<?php

$mode = (string)$_GET['mode'];
if($mode == ""){ $mode = "show"; }
else{
	$id = (string)$_GET['i'];
}

$redirect = "showcourses_edit.php?mode=show"; // redirect link

// pops up a javascript message box and then redirects to another page
function redirect($msg, $location){
	echo "<script language=\"javascript\">\n alert(\"".$msg."\"); \n window.location = \"".$location."\"; \n</script>";	
}

// show all courses
if($mode == "show"){

	echo "<table class=\"default\">";
	echo "<thead class=\"default\">";
	echo "<tr><td colspan=2>Course Management</td></tr></thead>";	
	echo "<tbody class=\"default\">";
	echo "<tr><td><a href=\"showcourses_edit.php?mode=delall\">Delete All</a></td><td><a href=\"showcourses_edit.php?mode=add\">Add</a></tr>\n";
	echo "</tbody></table>";

	$query = "select course_num, title, dept, credit from course order by course_num, dept, credit, title";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	echo "<br/><table class=\"default\">";
	echo "<thead class=\"default\">";
	echo "<tr><td colspan=10 align=center>All Courses</td></tr></thead>";	
	echo "<thead class=\"default\">";
	echo "<tr><td>Course Num</td><td>Title</td><td>Department</td><td>Credit Hours</td><td colspan=2 align=center>Manage</td></tr></thead>";	

	echo "<tbody class=\"default\">";

	while($row = mysql_fetch_assoc($result)){	
		$course_num = $row['course_num'];
		$title = $row['title'];
		$dept = $row['dept'];
		$credit = $row['credit'];
		echo "<tr>";
		echo "<td align=center>$course_num</td>";
		echo "<td>$title</td>";
		echo "<td align=center>$dept</td>";
		echo "<td align=center>$credit</td>";
		echo "<td><a href=\"showcourses_edit.php?mode=edit&i=$course_num\">Edit</a></td>";
		echo "<td><a href=\"showcourses_edit.php?mode=del&i=$course_num\">Delete</a></td>";
		echo "</tr>";
	}
	echo "</td></tbody></table>";
	mysql_free_result($result);
}
// show form for adding/editing
else if($mode == "add" || $mode == "edit"){
	showForm($mode, $id);
}
// form has been submitted, do checking and insert into db
else if($mode == "add_done"){
	$course_num = (string)$_POST['cnum1'].$_POST['cnum2'].$_POST['cnum3'];
	$dept = "CMPS";
	$title = (string)$_POST['title'];
	$hours = (string)$_POST['hours'];
	
	$query = "select count(*) as count from course where course_num = '$course_num'";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	$count = $row['count'];
	if($count == 0){
		$query = "insert into course values ('$course_num', '$title', '$dept', '$hours')";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		redirect("Add completed successfully.", $redirect);
	}
	else{
		redirect("Course already exists.", $redirect);
	}
}
// form has been submitted, do checking and update in db
else if($mode == "edit_done"){
	$course_num = $id;
	$dept = "CMPS";
	$title = (string)$_POST['title'];
	$hours = (string)$_POST['hours'];
	$query = "update course set title = '$title', dept = '$dept', credit = '$hours' where course_num = '$course_num'";
	mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	redirect("Update completed successfully.", $redirect);
}
// delete a course
else if($mode == "del"){
	$course_num = $id;
	$confirm = (string)$_GET['c'];

	// user confirms delete
	if($confirm == "yes"){
		$query = "delete from class where course_num = '$course_num'";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$query = "delete from course where course_num = '$course_num'";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		redirect("Course and related classes have been deleted.", $redirect);	
	}
	// show confirm
	else{
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2>Confirm Deletion of Course</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
		echo "<tr><td>All classes relating to the course will also be deleted.</td></tr>";
		echo "<tr><td align=center><a href=\"showcourses_edit.php?mode=del&i=$id&c=yes\">Confirm Delete</a></td></tr>";
		echo "</tbody>";
		echo "</table>";
	}
}
// delete all courses and classes 
else if($mode == "delall"){
	$confirm = (string)$_GET['c'];

	// user confirms
	if($confirm == "yes"){
		$query = "delete from class";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$query = "delete from course";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		redirect("All courses and classes have been deleted.", $redirect);	
	}
	// show a confirm page
	else{
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2>Confirm Deletion of ALL Courses</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
		echo "<tr><td>ALL classes and courses will be deleted.</td></tr>";
		echo "<tr><td align=center><a href=\"showcourses_edit.php?mode=delall&c=yes\">Confirm Delete ALL</a></td></tr>";
		echo "</tbody>";
		echo "</table>";
	}
}

// shows a form for editing/adding courses
function showForm($mode, $course_num){
	if($mode == "edit"){
		$query = "select title,credit from course where course_num = '$course_num'";
		$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		$row = mysql_fetch_assoc($result);
		$title = $row['title'];
		$credit = $row['credit'];
	}

	echo "<table class=\"default\">";
	echo "<thead class=\"default\">";
	echo "<tr><td colspan=10 align=center>".ucwords($mode)." Course</td></tr></thead>";	
	echo "<tbody class=\"default\">";
	if($mode == "edit"){ echo "<FORM method=\"post\" action=\"showcourses_edit.php?mode=edit_done&i=$course_num\">"; }
	else{ echo "<FORM method=\"post\" action=\"showcourses_edit.php?mode=add_done\">"; }
	echo "<tr><td>Course Number</td><td>";
		if($mode == "edit"){ echo "<input disabled type=text name=clabel value='$course_num' size=3>&nbsp;&nbsp;&nbsp;"; }
		else{ echo "<input disabled type=text name=clabel value=100 size=3>&nbsp;&nbsp;&nbsp;"; }

		if($mode == "add"){
			echo "<select name=\"cnum1\"  onchange=\"clabel.value=cnum1.options[cnum1.selectedIndex].value + cnum2.options[cnum2.selectedIndex].value + cnum3.options[cnum3.selectedIndex].value\">";
			$i = 1;
			while($i <= 6){
				echo "<option value=$i>$i</option>";
				$i = $i + 1;
			}
		 	echo "</select>";
			echo "<select name=\"cnum2\" onchange=\"clabel.value=cnum1.options[cnum1.selectedIndex].value + cnum2.options[cnum2.selectedIndex].value + cnum3.options[cnum3.selectedIndex].value\">";
			$i = 0;
			while($i <= 9){
				echo "<option value=$i>$i</option>";
				$i = $i + 1;
			}
		 	echo "</select>";		
			echo "<select name=\"cnum3\" onchange=\"clabel.value=cnum1.options[cnum1.selectedIndex].value + cnum2.options[cnum2.selectedIndex].value + cnum3.options[cnum3.selectedIndex].value\">";
			$i = 0;
			while($i <= 9){
				echo "<option value=$i>$i</option>";
				$i = $i + 1;
			}
		 	echo "</select>";
		}
		echo "</td></tr>";
	echo "<tr><td>Department</td><td>CMPS";
		//echo "<select name=department>";
		//	echo "<option value=CMPS>CMPS</a>";
		//echo "</select>";
		echo "</td></tr>";
	echo "<tr><td>Title</td><td><input type=text name=title value='$title' size=50 maxlength=50></td></tr>";
	echo "<tr><td>Credit Hours</td><td>";
		echo "<select name=\"hours\">";
		$i = 1;
		while($i <= 5){
			if($mode == "edit" && $credit == $i){ echo "<option selected value=$i>$i</option>"; }
			else{ echo "<option value=$i>$i</option>"; }
			$i = $i + 1;
		}
	 	echo "</select>";		
		echo "</td></tr>";	
	echo "<tr><td colspan=2 align=center><input type=\"submit\" value=\"Submit ".ucwords($mode)."\"></td></tr>";
	echo "</FORM>";
	echo "</tbody></table>";
}

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
