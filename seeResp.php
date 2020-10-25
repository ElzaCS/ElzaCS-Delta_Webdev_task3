<html>
<head>
<title>Responses</title>
</head>
<body background="https://st.depositphotos.com/1596326/2653/v/950/depositphotos_26532107-stock-illustration-seamless-rich-floral-background.jpg">
<?php
require_once('config.php');
//form id
$id = intval($_GET['id']);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Responses:</h2>";
echo "<center><table border='1' bgcolor='#b3f0ff' width='700px'><tr>";

//table name and description
$sql="select * from user_forms where formId=".$id.";";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res) ;
echo "<h1>Form Name: ".$row['form_name']."<h1>";
echo "<h2>Form Description: ".$row['form_desc']."<h2>";

//table heading or form labels
echo "<th>ResponseID</th>";
$sqlF="select * from forms where form_id=".$id.";";
$resF = mysqli_query($conn, $sqlF);
while($rowF =mysqli_fetch_array($resF, MYSQLI_ASSOC)) {
echo "<th>".$rowF['field_name']."</th>";
}
echo "</tr>";

//print responses
$sqlR="select * from form_".$id.";";
$resR = mysqli_query($conn, $sqlR);
while($rowR =mysqli_fetch_array($resR, MYSQLI_ASSOC)) {
    echo "<tr>";
    echo "<td>".$rowR['response_id']."</td> ";

    //get labels from forms table
    $sqlF="select * from forms where form_id=".$id.";";
    $resF = mysqli_query($conn, $sqlF);
    while($rowF =mysqli_fetch_array($resF, MYSQLI_ASSOC)) {
	$col=$rowF['field_name'];
	echo "<td>".$rowR[$col]."</td>";
   }
echo "</tr>";
}
echo "</table></center>";
?>
<br><center><a href="login.php"><strong>Back</strong></a></center>
</body>
</html>

