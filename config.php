<?php
ob_start();
ini_set('date.timezone', 'Asia/Ho_Chi_Minh');
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

require_once 'initialize.php';
require_once 'classes/DBConnection.php';

$dbPG = new DBConnectionPG;
$connPG = $dbPG->connPG;
$connSQLSV = $dbPG->conn;
