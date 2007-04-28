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
Editing of a class.
Allows the user to Add, Update, and Delete data for a specified class
*/
?>
<?php include("../adminheader.php"); ?>
<?php include("../connect.php"); ?>
<div id="content">
<?php


//Gets querystring data and sets the redirect page
$course_id = (string)$_GET['cid'];
$mode = (string)$_GET['mode'];
$redirect="classschedule.php";


// returns a hyperlink to a javascript popup message
function popuplink($msg,$linktext){
	return "<a href=\"javascript:alert('$msg')\">$linktext</a>";
}

//prints dropdown of course numbers
function courseNumDrop()
{
    $mode = (string)$_GET['mode'];    
    $query = "select course_num from course order by course_num";
    $result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
    
    if($mode == "edit"){
          echo "<select disabled name=course_num>\n";
    }
    else
    {
          echo "<select name=course_num>\n";

    }
    while($row = mysql_fetch_assoc($result)){
		
	$course_num=$row['course_num'];        
	echo "<option value=$course_num>CMPS $course_num</option>"; 
		
	
    }


    echo "</select>";
    mysql_free_result($result);

}

// pops up a javascript message box and then redirects to another page
function redirect($msg, $location){
	echo "<script language=\"javascript\">\n alert(\"".$msg."\"); \n window.location = \"".$location."\"; \n</script>";	
}


//Validation for the add a class
function checkdata($post_time,$post_year,$post_course_id)
{

//check for a decently formatted course id
	
        $tmp = $post_course_id;
        if(is_numeric($tmp))
        {
               $checkstring = $checkstring.".";
        } 


// check for a decently formatted year
        $tmp = $post_year;
	if(is_numeric($tmp))
        {
        	if ($tmp > 1900)
                {
                    $checkstring = $checkstring.".";
                }   
          
	} 

// check for a decently formatted time
       if($post_time == "" and strlen($checkstring) == 2)
       {
             return true;
       }
       else
       {	
       $tmp = explode("-", $post_time);
	if(count($tmp) == 2){
		$part1 = explode(":", $tmp[0]);
		$part2 = explode(":", $tmp[1]);
		if(count($tmp) == 2 && strlen($tmp[0]) >= 5 && strlen($tmp[1]) >= 5 && strlen($post_time) >= 11 && strlen($post_time) <= 13 && ((int)$part1[0]) != 0 && ((int)$part2[0]) != 0){
			$checkstring = $checkstring.".";
		}
	}

}
        if(strlen($checkstring) == 3){
		return true;
	}
	return false;


}


//validation for the edit class
function checkdata2($post_time)
{



// check for a decently formatted time
       if($post_time == "" )
       {
             return true;
       }
       else
       {	
       $tmp = explode("-", $post_time);
	if(count($tmp) == 2){
		$part1 = explode(":", $tmp[0]);
		$part2 = explode(":", $tmp[1]);
		if(count($tmp) == 2 && strlen($tmp[0]) >= 5 && strlen($tmp[1]) >= 5 && strlen($post_time) >= 11 && strlen($post_time) <= 13 && ((int)$part1[0]) != 0 && ((int)$part2[0]) != 0){
			$checkstring = $checkstring.".";
		}
	}

}
        if(strlen($checkstring) == 1){
		return true;
	}
	return false;


}

//prints a dropdown of the room numbers
function roomNumDrop()
{

$query = "select room_num from room where room_type = 'lecture'";
    $result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
   
    echo "<select name=room_num>\n";
   
    while($row = mysql_fetch_assoc($result)){
		
	$room_num=$row['room_num'];        
	echo "<option value=$room_num>Room $room_num</option>"; 
		
	
    }


    echo "</select>";
    mysql_free_result($result);

}

//prints a dropdown of the teachers
function teacherDrop()
{

$query = "select id,firstname,lastname from employee where position = 'faculty' order by lastname ";
    $result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
    echo "<select name=teacher_id>\n";
    while($row = mysql_fetch_assoc($result)){
		
	$id=$row['id'];
        $first_name=$row['firstname'];
        $last_name=$row['lastname'];        
	echo "<option value=$id>$first_name $last_name</option>"; 
		
    }
    echo "</select>";
    mysql_free_result($result);

}

//if no mode is present error
if($mode == ""){
	echo "ERROR: NO GET INFO!";
}

//if the mode is edit allows user to edit class
if($mode == "edit"){

	$query = "select * from class where course_id='$course_id' ";
	$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
	$row = mysql_fetch_assoc($result);
	$course_id = $row['course_id'];
	$course_num = $row['course_num'];
	$teacher_id = $row['teacher_id'];
	$section = $row['section'];
	$year = $row['year'];
	$term = $row['term'];
	$level = $row['level'];
	$room_num = $row['room_num'];
	$days = $row['days'];
	$post_time = $row['time'];
	mysql_free_result($result);
        $post_course_id = (string)$_POST['course_id'];
	$post_course_num = (string)$_POST['course_num'];
	$post_teacher_id = (string)$_POST['teacher_id'];
	$post_section = (string)$_POST['section'];
	$post_year = (string)$_POST['year'];
        $post_term = (string)$_POST['term'];
        $post_level = (string)$_POST['level'];
        $post_room_num = (string)$_POST['room_num'];
        $post_days = (string)$_POST['daysm'].(string)$_POST['dayst'].(string)$_POST['daysw'].(string)$_POST['daysr'].(string)$_POST['daysf'].(string)$_POST['dayss'].(string)$_POST['daysu']; 
        $post_time = (string)$_POST['time'];

if(!($post_course_id == "" && $post_course_num == "" && $post_year == "" && $post_term == "" && $post_level == "" && $post_room_num == ""))
{

// making sure we aren't clashing with another class
     $count_course = 0;
          
     
     if($count_course == 0)
     {
        $oktogo = checkdata2($post_time);
	if(!$oktogo)
        { 
	      	redirect("There was an error processing the data, no changes will be made.", $redirect); 
        }
        else{       
              	$query = "update class set section='$post_section', days='$post_days' , time='$post_time', level='$post_level', teacher_id='$post_teacher_id', room_num='$post_room_num' where course_id = '$course_id' ";
		mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
		redirect("Class has been updated.", $redirect);
	}	
     
     }
     else
     {
      	redirect("Class already exists.", $redirect);
     } 

}
else
{
	echo "<table class=\"default\">";
	echo "<thead class=\"default\">";
	echo "<tr><td colspan=2 align=center>Edit Class</td></tr></thead>";	
	echo "<tbody class=\"default\">";
	echo "<form method=post action=\"class_edit.php?mode=edit&cid=$course_id\" >\n";
	echo "<tr>\n";
	echo "<td>Course ID*: </td><td><input disabled name=course_id value=$course_id type=text></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Course Number*: </td><td>"; 
      		courseNumDrop();
	echo "</td></tr>\n";
	echo "<tr><td>Section: </td><td><input name=section value='$section' type=text></td></tr>";
	echo "<tr><td>Year*: </td><td><input disabled name=year value=$year type=text> ".popuplink("Date must be formatted like YYYY-MM-DD. For example: 2007-05-22.", "?")."</td></tr>";
	echo "<tr><td>Term*: </td><td>\n";
	echo "<select disabled value=$term name=term>\n";
	echo "<option value=FA>Fall</option>\n";
	echo "<option value=WN>Winter</option>\n";
	echo "<option value=SP>Spring</option>\n";
	echo "<option value=SU>Summer</option></td></tr>\n";

	echo "<tr><td>Level*: </td><td>\n";
	echo "<select disabled value=$level name=level>\n";
	echo "<option value=UN>Undergraduate</option>\n";
	echo "<option value=GR>Graduate</option>\n";
	echo "<option value=GRUN>Undergraduate/Graduate</option></td></tr>\n";
	echo "<tr><td>Room Number*: </td><td>"; 
	roomNumDrop();
	echo "</td></tr>";

	echo "<tr><td>Teacher*: </td><td>\n";
	teacherDrop();
	echo "</td></tr>\n";

	echo "<tr><td>Days: </td><td><input type=\"checkbox\" name=\"daysm\" value=\"m\" > Monday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"dayst\" value=\"t\" > Tuesday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"daysw\" value=\"w\" > Wednesday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"daysr\" value=\"r\" > Thursday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"daysf\" value=\"f\" > Friday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"dayss\" value=\"s\" > Saturday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"daysu\"  value=\"u\" > Sunday</td></tr>";
	echo "<tr><td>Time: </td><td><input name=time type=text>  ".popuplink("Time must be formatted like H:MMA-H:MMP. For example, the following are acceptable: 3:00A-3:30A; 3:00P-3:30P; 10:00A-10:00P; 12:00P-1:00A.", "?")."</td></tr>";

	echo "<tr><td colspan=2 align=center><input value=Submit type=submit></td></tr>";
	echo "</form></tbody></table>";
}
}
//if the mode is del allows user to delete the class
else if($mode == "del"){

$query="delete from class where course_id = '$course_id' ";
mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
redirect("Class has been deleted.", $redirect);

}

//if the mode is delete all deletes all classes in the database
else if($mode == "delall"){

// get data for a confirmation
$confirm = (string)$_GET['confirm'];
// user has confirmed they wish to delete all classes

if($confirm == 'y'){	
     $query="delete from class ";
     mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
     echo "<script language=\"javascript\">\n alert(\"All classes have been deleted.\"); \n window.location = \"".$redirect."\"; \n</script>";			
	}	
	// user hasn't yet confirmed they wish to delete all classes, so give them the choice
	else{
		echo "<br/><table class=\"default\">";
		echo "<thead class=\"default\"><tr>";
		echo "<td colspan=2>Confirm Deletion of ALL Classes</td>";
		echo "</tr></thead>";
		echo "<tbody class=\"default\">";
echo "<tr><td><a href=\"class_edit.php?mode=delall&confirm=y\">Confirm Delete</a></td></tr>";
		echo "</tbody>";
		echo "</table>";
	}		


}

//if the mode is add allows user to add a class
else if($mode == "add"){
        
        $post_course_id = (string)$_POST['course_id'];
	$post_course_num = (string)$_POST['course_num'];
	$post_teacher_id = (string)$_POST['teacher_id'];
	$post_section = (string)$_POST['section'];
	$post_year = (string)$_POST['year'];
        $post_term = (string)$_POST['term'];
        $post_level = (string)$_POST['level'];
        $post_room_num = (string)$_POST['room_num'];
        $post_days = (string)$_POST['daysm'].(string)$_POST['dayst'].(string)$_POST['daysw'].(string)$_POST['daysr'].(string)$_POST['daysf'].(string)$_POST['dayss'].(string)$_POST['daysu']; 
        $post_time = (string)$_POST['time'];
        
if(!($post_course_id == "" && $post_course_num == "" && $post_year == "" && $post_term == "" && $post_level == "" && $post_room_num == ""))
{

	// making sure we aren't clashing with another class
     $count_course = 0;
     $query = "select count(*) as count from class where course_id = '$post_course_id' ";
     $result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
     $row = mysql_fetch_assoc($result);
     $count_course = (int)$row['count'];
     mysql_free_result($result);
     /*
     $query = "select count(*) as count from class where course_id = '$post_course_id' and year='$post_year' and term='post_term' ";
			$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			$row = mysql_fetch_assoc($result);
			$count_course += (int)$row['count'];
			mysql_free_result($result);
	*/
 $query = "select count(*) as count from class where year='$post_year' and term='$post_term' and room_num = '$post_room_num'  and time = '$post_time' and days = '$post_days'";
			$result = mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			$row = mysql_fetch_assoc($result);
			$count_course += (int)$row['count'];
			mysql_free_result($result);

	
     if($count_course == 0)
     {
        

          $oktogo = checkdata($post_time, $post_year, $post_course_id);
		if(!$oktogo)
        { redirect("There was an error processing the data, no changes will be made.", $redirect); }
		else{       
$query = "insert into class set year='$post_year', term='$post_term', course_num='$post_course_num', course_id='$post_course_id' , section='$post_section', days='$post_days' , time='$post_time', level='$post_level', teacher_id='$post_teacher_id', room_num='$post_room_num' ";
			mysql_query((string)$query) or die('BAD QUERY '.mysql_error());
			redirect("Class has been added.", $redirect);
		}	
     
     }
     else
     {
     redirect("Class already exists.", $redirect);
     } 

}
else
{
	echo "<table class=\"default\">";
	echo "<thead class=\"default\">";
	echo "<tr><td colspan=2 align=center>Add Class</td></tr></thead>";	
	echo "<tbody class=\"default\">";

	echo "<form method=post action=\"class_edit.php?mode=add\" >\n";
	echo "<tr>\n";
	echo "<td>Course ID*: </td><td><input name=course_id type=text></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Course Number*: </td><td>"; 
	      courseNumDrop();
	echo "</td></tr>\n";
	echo "<tr><td>Section: </td><td><input name=section type=text></td></tr>";
	echo "<tr><td>Year*: </td><td><input name=year type=text> ".popuplink("Date must be formatted like YYYY-MM-DD. For example: 2007-05-22.", "?")."</td></tr>";
	echo "<tr><td>Term*: </td><td>\n";
	echo "<select name=term>\n";
	echo "<option value=FA>Fall</option>\n";
	echo "<option value=WN>Winter</option>\n";
	echo "<option value=SP>Spring</option>\n";
	echo "<option value=SU>Summer</option></td></tr>\n";

	echo "<tr><td>Level*: </td><td>\n";
	echo "<select id=level name=level>\n";
	echo "<option value=UN>Undergraduate</option>\n";
	echo "<option value=GR>Graduate</option>\n";
	echo "<option value=GRUN>Undergraduate/Graduate</option></td></tr>\n";
	echo "<tr><td>Room Number*: </td><td>"; 
	roomNumDrop();
	echo "</td></tr>";

	echo "<tr><td>Teacher*: </td><td>\n";
	teacherDrop();
	echo "</td></tr>\n";

	echo "<tr><td>Days: </td><td><input type=\"checkbox\" name=\"daysm\" value=\"m\" > Monday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"dayst\" value=\"t\" > Tuesday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"daysw\" value=\"w\" > Wednesday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"daysr\" value=\"r\" > Thursday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"daysf\" value=\"f\" > Friday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"dayss\" value=\"s\" > Saturday</td></tr>";
	echo "<tr><td></td><td><input type=\"checkbox\" name=\"daysu\"  value=\"u\" > Sunday</td></tr>";
	echo "<tr><td>Time: </td><td><input name=time type=text>  ".popuplink("Time must be formatted like H:MMA-H:MMP. For example, the following are acceptable: 3:00A-3:30A; 3:00P-3:30P; 10:00A-10:00P; 12:00P-1:00A.", "?")."</td></tr>";

	echo "<tr><td colspan=2 align=center><input value=Submit type=submit></td></tr>";
	echo "</form></tbody></table>";
}


}
//The mode is invalid
else{
	echo "ERROR: BAD GET INFO!";
}

?>


</div>
<?php include("../close.php"); ?>
<?php include("../footer.php"); ?>
