<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "libraryDB";

$con = new mysqli($host,$username,$password,$database);

if ($con->connect_error) {
    die('connection failed'. $con->connect_error);
}
else {
    // echo "Success";
}