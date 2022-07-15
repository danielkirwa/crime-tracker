<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_crimecon = "localhost";
$database_crimecon = "bg_crime_log";
$username_crimecon = "root";
$password_crimecon = "";
$crimecon = mysql_pconnect($hostname_crimecon, $username_crimecon, $password_crimecon) or trigger_error(mysql_error(),E_USER_ERROR); 
?>