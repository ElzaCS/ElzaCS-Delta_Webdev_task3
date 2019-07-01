<html>
<head>
<?php
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

session_start();

//invalid login
if ($_SESSION['user']==null) {
 echo "<h2>PLease login first</h2>";
 echo "<a href='http://proxy/wall.php'><h3>Go to Home Page</h3></a>";
}
else {
//new form
if ($_POST['fname']!=null) {
   //assign form name to session
   $_SESSION['fname']=$_POST['fname'];
 
   //add form name&desc to myUsers
   $sql="insert into myUsers (name,form_name,form_desc,form_id) values('".$_SESSION['user']."','".$_POST['fname']."','".$_POST['fdesc']."',".$_SESSION['fid'].");"; 
   if ($conn->query($sql) === FALSE) {  echo "<br>shocking: ".$sql."<br>";   }
}

?>
<title></title>
<link rel="stylesheet" href="login.css"></head>
<body background="https://st.depositphotos.com/1596326/2653/v/950/depositphotos_26532107-stock-illustration-seamless-rich-floral-background.jpg">

<button onclick="document.getElementById('id03').style.display='block'" style="height:35px;width:10%;float:right;">Back</button>
<!--back-->
<div id="id03" class="modal">
  <span onclick="document.getElementById('id03').style.display='none'" 
class="close" title="Close Modal">&times;</span>
<form class="modal-content animate" action="http://proxy/login.php" method="post">
    <div class="container">
    <label><b>Are you sure you want to leave the form?</b></label>
    <br>
    <button type="submit" style="height:27px;width:100%;">Yes</button>
  </div>
</form>
</div>
<!-- --->
<!-- form to take field labels-->
<p><h1>Your new form: <?php session_start(); echo $_SESSION['fname'];?></h1></p>
<center><table width='700px' frame='box' class="tabid" style="position:relative; padding:0;" bgcolor='#b3f0ff'>
   <form class="newstuff" action="http://proxy/form.php" method="post" style="text-align: left;"> 
    <tr><td><label for="tname"><b>Field Label</b></label></td>
         <td><input type="text" placeholder="enter label(single word, no spaces)" name="txt" style="width:100%;" required></td></tr>

    <tr><td><label for="tdesc"><b>Field Type</b></label></td>
    <td> <select name='typ'><option value="text">Text</option><option value="number">Number</option></select></td></tr>
    <tr><td colspan='2'><center><button type="submit" name="numsubmitbtn" style="height:40px;width:235px">Add Field</button></center></td></tr>
   </form>
</table></center>
<!-- -->

<?php
//create table "form_formID" for responses
$sql="create table form_".$_SESSION['fid']." (response_id int(10) unsigned);";
if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>"; 
  }

//sql to add text fields to form
if ($_POST['typ']=="text") {
  $sql="insert into forms (form_id,field_name,field_type) values(".$_SESSION['fid'].",'".$_POST['txt']."','text');"; 
  if ($conn->query($sql) === FALSE) {  echo "<br>error in: ".$sql."<br>";   }
//add the text field label to responses table
  $sql="alter table form_".$_SESSION['fid']." add column ".$_POST['txt']." varchar(20) not null;";
  if ($conn->query($sql) === FALSE) {  echo "<br>error in: ".$sql."<br>"; }
}

//sql to add number fields to form
if ($_POST['typ']=="number") {
  $sql="insert into forms (form_id,field_name,field_type) values(".$_SESSION['fid'].",'".$_POST['txt']."','number');"; 
  if ($conn->query($sql) === FALSE) {  echo "<br>error in: ".$sql."<br>";   }

  //add the number field label to responses table
  $sql="alter table form_".$_SESSION['fid']." add column ".$_POST['txt']." varchar(20) not null;";
  if ($conn->query($sql) === FALSE) {  echo "<br>error in: ".$sql."<br>"; }
}


//PRINTING FORM PREVIEW
 $sqlN="select * from myUsers where form_id=".$_SESSION['fid'].";";
$resN = mysqli_query($conn, $sqlN);
$rowN = mysqli_fetch_array($resN) ;
//form name & description
echo "<br><center><h2><u>Form Preview</u></h2><table style='border-style: dashed;' bgcolor='#b3d9ff' width='700px'>";
echo "<tr><td colspan='2'><center><h3>".$rowN['form_name']."</h3></center></td></tr>";
echo "<tr><td colspan='2'><center>".$rowN['form_desc']."</center></td></tr>";
//form data
$sqlN="select * from forms where form_id=".$_SESSION['fid'].";";
$resN = mysqli_query($conn, $sqlN);
 while($rowN =mysqli_fetch_array($resN, MYSQLI_ASSOC)) {
echo "<tr><td><label>".$rowN['field_name']."</label></td>";
echo "<td><input type=".$rowN['field_type']." style='width:100%'></input></td></tr>";
}
echo "</table><center>"; 

?>
<center><button onclick="document.getElementById('id04').style.display='block'" style="height:50px;width:235px;float:center;">Save Form & Get Link</button></center>
<!-- Save Form & Get Link -->
<div id="id04" class="modal">
  <span onclick="document.getElementById('id04').style.display='none'" 
class="close" title="Close Modal">&times;</span>
<form class="modal-content animate" action="http://proxy/login.php" method="post">
    <div class="container">
    <label><b>Form url</b></label>
    <p>http://proxy/final.php?id=<?php session_start(); echo $_SESSION['fid']; ?></p>
    <br>
    <button type="submit" style="height:27px;width:100%;">Complete</button>
  </div>
</form>
</div>
<!-- -->
<?php } ?>
</body>
</html>
