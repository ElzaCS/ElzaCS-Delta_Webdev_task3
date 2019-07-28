<?php
$t1=$_POST['time1'];
$t2=$_POST['time2'];
$t3=$_POST['time3'];

session_start();

$servername="localhost";
$username="root";
$password="redhat";
$dbname="wallDB";

//Create connection
$conn=new mysqli($servername,$username,$password,$dbname);
//check connection
if ($conn->connect_error) {
  die("Connection failed".$conn->connect_error);
}

//add to db
$sql="update myUsers set date=".$t1". where form_id=".$_SEESION['fid'];
if ($conn->query($sql)===FALSE) {}
$sql="update myUsers set month=".$t2". where form_id=".$_SEESION['fid'];
if ($conn->query($sql)===FALSE) {}
$sql="update myUsers set year=".$t3". where form_id=".$_SEESION['fid'];
if ($conn->query($sql)===FALSE) {}
header("Location: form.php");
?>
