<?php
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'root';
$DB_NAME = 'flow5';

//$DB_HOST = 'troelsm.com.mysql';
//$DB_USER = 'troelsm_com';
//$DB_PASS = '';
//$DB_NAME = 'troelsm_com';

$link = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($link->connect_error) {
    die('Connect Error ('.$link->connect_errno.') '.$link->connect_error);
	echo "yupii";
}
$link->set_charset('utf8');
//require 'functions.php';
?>