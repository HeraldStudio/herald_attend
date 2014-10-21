<?php
$conn = mysql_connect('localhost', 'root', '123456');

if(!$conn) {
	echo "Database connect error:" . mysql_error();
	die();
}

mysql_select_db('herald_attend');