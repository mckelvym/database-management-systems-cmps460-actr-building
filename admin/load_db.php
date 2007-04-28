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
<?php
	
	//mysql_query("select 'Loading admin';") or die('BAD QUERY '.mysql_error());
	//mysql_query("load data local infile 'admin.data' ignore into table admin fields terminated by ',';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading officehours';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/officehours.data' ignore into table officehours fields terminated by ',';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading events';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/events.data' ignore into table events fields terminated by ',';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading seminars';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/seminars.data' ignore into table seminar fields terminated by ',';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading offices';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/offices.data' ignore into table office fields terminated by ',';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading classroom';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/lectures.data' ignore into table classroom fields terminated by ',';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading researchlabs';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/rlabs.data' ignore into table researchlab fields terminated by ',';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading computerlabs';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/clabs.data' ignore into table computerlab fields terminated by ',';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading classes';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/classes.data' ignore into table class fields terminated by ',' lines terminated by '\r\n';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading courses';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/course.data' ignore into table course fields terminated by ',' lines terminated by '\r\n';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading rooms';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/rooms.data' ignore into table room fields terminated by ',';") or die('BAD QUERY '.mysql_error());
	
	mysql_query("select 'Loading employees';") or die('BAD QUERY '.mysql_error());
	mysql_query("load data local infile '../data/employee.data' ignore into table employee fields terminated by ',';") or die('BAD QUERY '.mysql_error());


?>
