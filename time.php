<?php
require_once('config.php');
$t1 = $_POST['time1'];
$t2 = $_POST['time2'];
$t3 = $_POST['time3'];
//echo $t1."<br>".$t2."<br>".$t3."<br>";

session_start();
//echo $_SESSION['fid']."<br>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//add to db
$sql="update myUsers set date=".$t1." where form_id=".$_SESSION['fid']."";
if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>";   
  } //else echo "true";
$sql="update myUsers set month=".$t2." where form_id=".$_SESSION['fid']."";
if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>";   
  } //else echo "true";
$sql="update myUsers set year=".$t3." where form_id=".$_SESSION['fid']."";
if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>";   
  } //else echo "true";
header("Location: form.php");
?>
