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

echo "<center><form action='getResp.php' method='post'><table frame='box' bgcolor='#b3f0ff'>";

$sqlm="select * from myUsers where form_id=".$id.";";
$resm = mysqli_query($conn, $sqlm);
$rowm = mysqli_fetch_array($resm) ;
    $gd=$rowm['date'];
    $gm=$rowm['month'];
    $gy=$rowm['year'];
    
$sqln="select now();";
$resn = mysqli_query($conn, $sqln);
$rown = mysqli_fetch_array($resn);
    $date=date("d/m/Y");
    $td=substr($date,0,2);
    $tm=substr($date,3,2);
    $ty=substr($date,6,4);
    
if ( ($ty<$gy) || (($ty==$gy) && ($tm<$gm)) || (($ty==$gy) &&($tm==$gm) && ($td<=$gd)) ) {
$sqlm="select * from myUsers where form_id=".$id.";";
$resm = mysqli_query($conn, $sqlm);
$rowm = mysqli_fetch_array($resm) ;
    echo "<h1>".$rowm['form_name']."</h1><br>";
echo "<h2>".$rowm['form_desc']."</h2><br>";

echo "<tr><td><input type='hidden' id='fid' name='fid' value=".$id."></td></tr>";

 $sqlN="select * from forms where form_id=".$id.";";
 $resN = mysqli_query($conn, $sqlN);
 while($rowN =mysqli_fetch_array($resN, MYSQLI_ASSOC)) {
if ($rowN['field_type']=="image") {
    echo "<tr><td><img src='".$rowN['field_name']."' widht='200' height='200'></td>";
}
else if ($rowN['field_type']=="radio") {
    echo "<tr><td><img src='".$rowN['field_name']."</label></td></tr>";
    if ($rowN['name1']!=null) echo "<input type='radio' name='".$rowN['field_name']."' value='".$rowN['name1']."'>".$rowN['name1'];
    if ($rowN['name2']!=null) echo "<input type='radio' name='".$rowN['field_name']."' value='".$rowN['name2']."'>".$rowN['name2'];
    if ($rowN['name3']!=null) echo "<input type='radio' name='".$rowN['field_name']."' value='".$rowN['name3']."'>".$rowN['name3'];
    if ($rowN['name4']!=null) echo "<input type='radio' name='".$rowN['field_name']."' value='".$rowN['name4']."'>".$rowN['name4'];
    echo "</td></tr>";
}
else if ($rowN['field_type']=="dropdown") {
    echo "<tr><td><label>".$rowN['field_name']."</label></td><td><select name='".$rowN['field_name']."'>";
    if ($rowN['name1']!=null) echo "<option value'".$rowN['name1']."'>".$rowN['name1']."</option>";
    if ($rowN['name2']!=null) echo "<option value'".$rowN['name2']."'>".$rowN['name2']."</option>";
    if ($rowN['name3']!=null) echo "<option value'".$rowN['name3']."'>".$rowN['name3']."</option>";
    if ($rowN['name4']!=null) echo "<option value'".$rowN['name4']."'>".$rowN['name4']."</option>";
    echo "<select></td>";
}
else {
echo "<tr><td><label>".$rowN['field_name']."</label></td>";
echo "<td><input type=".$rowN['field_type']." style='width:100%' name='".$rowN['field_name']."' required></input></td></tr>";
}}
session_start();
   $rand=rand();
   $_SESSION['rid']=$rand;
echo "<tr><td colspan='2'><center><button type='submit'>Submit</button></center></td></tr>";
echo "</table></form></center>"; 
}
    else
        echo "Sorry. The deadline to submit this form is over.";
?>
</body>
</html>
