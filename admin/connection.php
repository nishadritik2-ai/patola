<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$con =mysqli_connect("localhost","root","","patola");
$conn =mysqli_connect("localhost","root","","patola");

if($con){
    // echo "connection is done";
}

?>