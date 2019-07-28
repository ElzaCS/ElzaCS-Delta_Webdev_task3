<?php
$field = $_REQUEST['field'];
$type = $_REQUEST['type'];
session_start();
$fid=$_SESSION['fid'];

$servername = "localhost";
$username = "root";
$password = "redhat";
$dbname = "wallDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "fid=".$fid.", field=".$field.", type=".$type;

//delete from db
$sql="delete from forms where form_id=".$fid." and field_name='".$field."' and field_type='".$type."';";
  if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>";   
  }
header("Location: form.php");
?>
