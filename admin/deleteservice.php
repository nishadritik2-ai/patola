<?php include "connection.php";
$id = $_GET['id'];

$sql ="DELETE FROM services WHERE id = $id";
 $result =mysqli_query($con,$sql);
 if($result=true){
    // echo "update sucessfully";
    header("location:index.php");
}


 ?>