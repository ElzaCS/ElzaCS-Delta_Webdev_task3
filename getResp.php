
<html>
<head><title>responses</title></head>
<body>
<h3>Thank you! Your response has been submitted.</h3>
<?php
require_once('config.php');

session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//insert responseID to responses table
$sql="insert into form_".$_POST['fid']." (response_id) values(".$_SESSION['rid'].");";
if ($conn->query($sql) === FALSE) {  echo "<br>shocking: ".$sql."<br>";   }

//get labels from forms table
$sqlN="select * from forms where form_id=".$_POST['fid'].";";
$resN = mysqli_query($conn, $sqlN);
//insert responses to responses table
while($rowN =mysqli_fetch_array($resN, MYSQLI_ASSOC)) {
$var=$rowN['field_name'];
    if ($rowN['field_type']!="image") {
$sql="update form_".$_POST['fid']." set ".$var."='".$_POST[$var]."' where response_id=".$_SESSION['rid'].";";
 if ($conn->query($sql) === FALSE) {  echo "<br>shocking: ".$sql."<br>";   }
}}
?>

</body>
</html>
