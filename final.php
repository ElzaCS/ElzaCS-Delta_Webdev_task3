<html>
<head>
<title>form</title>

</head>
<body>
<?php
$id = intval($_GET['id']);
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

echo "<center><form action='http://proxy//getResp.php' method='post'><table frame='box' bgcolor='#b3f0ff'>";

$sqlm="select * from myUsers where form_id=".$id.";";
$resm = mysqli_query($conn, $sqlm);
$rowm = mysqli_fetch_array($resm) ;
echo "<h1>".$rowm['form_name']."</h1><br>";
echo "<h2>".$rowm['form_desc']."</h2><br>";
echo "<tr><td><input type='hidden' id='fid' name='fid' value=".$id."></td></tr>";

 $sqlN="select * from forms where form_id=".$id.";";
 $resN = mysqli_query($conn, $sqlN);
 while($rowN =mysqli_fetch_array($resN, MYSQLI_ASSOC)) {
echo "<tr><td><label>".$rowN['field_name']."</label></td>";
echo "<td><input type=".$rowN['field_type']." style='width:100%' name='".$rowN['field_name']."' required></input></td></tr>";
}
session_start();
   $rand=rand();
   $_SESSION['rid']=$rand;
echo "<tr><td colspan='2'><center><button type='submit'>Submit</button></center></td></tr>";
echo "</table></form></center>"; 
?>
</body>
</html>
