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
	mysql_query("drop table if exists officehours;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists events;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists seminar;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists office;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists classroom;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists computerlab;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists researchlab;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists class;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists course;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists room;") or die('BAD QUERY '.mysql_error());
	mysql_query("drop table if exists employee;") or die('BAD QUERY '.mysql_error());
	//mysql_query("drop table if exists admin;") or die('BAD QUERY '.mysql_error());
	
	//mysql_query("create table admin( id int(4) not null auto_increment, user_name varchar(50), password varchar(50), primary key (id));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table employee( id varchar(11), lastname varchar(250), firstname varchar(250), office_num varchar(4), phone	varchar(12), photo varchar(250), website varchar(250), position	varchar(250), primary key (id));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table room( room_num varchar(4), room_type varchar(30), primary key (room_num));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table course( course_num int, title varchar(250), dept varchar(250), credit int, primary key (course_num));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table class( year int, term char(2), course_num int, course_id int, section varchar(4), days  varchar(6), time varchar(20), level varchar(4), teacher_id varchar(11), room_num varchar(4), foreign key (course_num) references course (course_num),	primary key (course_id), foreign key (teacher_id) references employee (id), foreign key (room_num) references room (room_num));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table computerlab(room_num varchar(4), num_computers int, type_computers varchar(30),	contact_id varchar(11),	hours varchar(20), days varchar(6),	purpose varchar(250), primary key (room_num), foreign key (room_num) references room (room_num),foreign key (contact_id) references employee (id));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table researchlab( room_num varchar(4), contact_id varchar(30), hours varchar(20), days varchar(6), purpose varchar(250), primary key (room_num), foreign key (room_num) references room (room_num), foreign key (contact_id) references employee (id));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table classroom( room varchar(4), num_seats int, primary key (room), foreign key (room) references room (room_num));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table office(room varchar(4), occupant_id varchar(11), primary key (room,occupant_id), foreign key (room) references room (room_num), foreign key (occupant_id) references employee (id));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table seminar( room_num varchar(4), contact_id varchar(11), date date, time varchar(20), purpose varchar(250), primary key (room_num,date,time), foreign key (room_num) references room (room_num), foreign key (contact_id) references employee (id));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table events( date date, time varchar(20), contact_id varchar(11), location varchar(250), purpose varchar(250), primary key (date,time,location), foreign key (contact_id) references employee (id));") or die('BAD QUERY '.mysql_error());
	mysql_query("create table officehours( id varchar(11), day varchar(9), time varchar(20), primary key (id, day, time), foreign key (id) references employee (id));") or die('BAD QUERY '.mysql_error());
?>
