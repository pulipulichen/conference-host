<?php
# FileName = "Connection_php_mysql.htm"
# Type = "MYSQL"
# HTTP = "true"
$hostname_conn = "localhost:3306";
//$database_conn = "ntec";
$database_conn = "conference_host";
$username_conn = "root";
$password_conn = "password";
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(), E_USER_ERROR); 
mysql_query("SET NAMES 'utf8'",$conn);

include_once "php_adapter.php";
