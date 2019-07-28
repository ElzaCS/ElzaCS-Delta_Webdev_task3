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
 echo "<a href='wall.php'><h3>Go to Home Page</h3></a>";
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
<form class="modal-content animate" action="login.php" method="post">
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
   <form class="newstuff" action="form.php" method="post" style="text-align: left;"> 
    <tr><td><label for="tname"><b>Field Label</b></label></td>
         <td><input type="text" placeholder="enter label(single word, no spaces)" name="txt" style="width:100%;" required></td></tr>

    <tr><td><label for="tdesc"><b>Field Type</b></label></td>
    <td> <select name='typ'><option value="text">Text</option><option value="number">Number</option><option value="image">Image</option><option value="dropdown">Dropdown</option><option value="radio">Radio</option></select></td></tr>
    <tr><td colspan='2'><center><button type="submit" name="numsubmitbtn" style="height:40px;width:235px">Add Field</button></center></td></tr>
   </form>
</table></center>
<!-- -->
<?php if ($_POST['typ']!='') { ?>
<form class="newstuff2" action="form.php" method="post" style="text-align:left;">
    <tr><td><label><b>Field Type</b></label></td>
        <td><?php echo $_POST['typ'];?><input name='typ' type='hidden' value'<?php echo $_POST['typ'];?>'></input></td></tr>
            <tr><td><label><b>Field Name</b></label></td>
            <?php if ($_POST['typ']=="dropdown" || $_POST['typ']=="radio") {
    echo "<tr><td><Label><b>Option1 Label</b></label></td>";
    echo "<td><input type='text' placeholder='enter label(no spaces)' name='op1' style='width:100%;' required</td></tr>";
    echo "<tr><td><Label><b>Option2 Label</b></label></td>";
    echo "<td><input type='text' placeholder='enter label(no spaces)' name='op2' style='width:100%;' required</td></tr>";
    echo "<tr><td><Label><b>Option3 Label</b></label></td>";
    echo "<td><input type='text' placeholder='enter label(no spaces)' name='op3' style='width:100%;' required</td></tr>";
    echo "<tr><td><Label><b>Option4 Label</b></label></td>";
    echo "<td><input type='text' placeholder='enter label(no spaces)' name='op4' style='width:100%;' required</td></tr>";
}?>
   <tr><td colspan='2'><center><button type="submit" name="numsubmitbtn" style="height:40px;width:235px;'>Add Field</button></center></td></tr>
</form>
<?php }?>
</table></center>
<?php    
//create table "form_formID" for responses
$sql="create table form_".$_SESSION['fid']." (response_id int(10) unsigned);";
if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>"; 
  }

//sql to add text fields to form
if ($_POST['typ']=="text" && $_POST['txt']!=null) {
  $sql="insert into forms (form_id,field_name,field_type) values(".$_SESSION['fid'].",'".$_POST['txt']."','text');"; 
  if ($conn->query($sql) === FALSE) {  echo "<br>error in: ".$sql."<br>";   }

  //add the text field label to responses table
  $sql="alter table form_".$_SESSION['fid']." add column ".$_POST['txt']." varchar(20) not null;";
  if ($conn->query($sql) === FALSE) {  echo "<br>error in: ".$sql."<br>"; }
}

//sql to add number fields to form
if ($_POST['typ']=="number" && $_POST['txt']!=null) {
  $sql="insert into forms (form_id,field_name,field_type) values(".$_SESSION['fid'].",'".$_POST['txt']."','number');"; 
  if ($conn->query($sql) === FALSE) { // echo "<br>error in: ".$sql."<br>";   
  }

  //add the number field label to responses table
  $sql="alter table form_".$_SESSION['fid']." add column ".$_POST['txt']." varchar(20) not null;";
  if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>"; 
  }
}
    
 //sql to add image to form
    if ($_POST['typ']=="image" && $_POST['txt']!=null) {
        $sql="insert into forms (form_id,field_name,field_type) values(".$_SESSION['fid'].",'".$_POST['txt']."','image');"; 
 
 //sql to add dropdown to form
if ($_POST['typ']=="dropdown" && $_POST['txt']!=null) {
  $sql="insert into forms (form_id,field_name,field_type) values(".$_SESSION['fid'].",'".$_POST['txt']."','dropdown');"; 
  if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>"; 
 }

  //add the dropdown field label to responses table
  $sql="alter table form_".$_SESSION['fid']." add column ".$_POST['txt']." varchar(1000) not null;";
  if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>"; 
 }
    //echo "<br>".$_POST['op1'].", ".$_POST['op2'].", ".$_POST['op3'].", ".$_POST['op4'];
    if ($_POST['op1']!='')
        $sql="update forms set name1='".$_POST['op1']."' where field_name='".$_POST['txt']."';";
        if ($conn->query($sql)===FALSE) {}
        $sql="update forms set name2='".$_POST['op2']."' where field_name='".$_POST['txt']."';";
        if ($conn->query($sql)===FALSE) {}
        $sql="update forms set name3='".$_POST['op3']."' where field_name='".$_POST['txt']."';";
        if ($conn->query($sql)===FALSE) {}
        $sql="update forms set name4='".$_POST['op4']."' where field_name='".$_POST['txt']."';";
        if ($conn->query($sql)===FALSE) {}
    
} 
 //sql to add radio to form
if ($_POST['typ']=="radio" && $_POST['txt']!=null) {
  $sql="insert into forms (form_id,field_name,field_type) values(".$_SESSION['fid'].",'".$_POST['txt']."','radio');"; 
  if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>"; 
 }

  //add the radio field label to responses table
  $sql="alter table form_".$_SESSION['fid']." add column ".$_POST['txt']." varchar(1000) not null;";
  if ($conn->query($sql) === FALSE) {  //echo "<br>error in: ".$sql."<br>"; 
 }
    //echo "<br>".$_POST['op1'].", ".$_POST['op2'].", ".$_POST['op3'].", ".$_POST['op4'];
    if ($_POST['op1']!='')
        $sql="update forms set name1='".$_POST['op1']."' where field_name='".$_POST['txt']."';";
        if ($conn->query($sql)===FALSE) {}
        $sql="update forms set name2='".$_POST['op2']."' where field_name='".$_POST['txt']."';";
        if ($conn->query($sql)===FALSE) {}
        $sql="update forms set name3='".$_POST['op3']."' where field_name='".$_POST['txt']."';";
        if ($conn->query($sql)===FALSE) {}
        $sql="update forms set name4='".$_POST['op4']."' where field_name='".$_POST['txt']."';";
        if ($conn->query($sql)===FALSE) {}
    
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
     if ($rowN['field_type']=="image")
       echo "<tr><td><img src='".$rowN['field_name']."' width='200' height='200'></td></tr>";
     else if ($rowN['field_type']=="dropdown") {
        echo "<tr><td>".$rowN['field_name']."</td><td><select>";
         if ($rowN['name1']!=null) echo "<option>".$rowN['name1']."</option>";
         if ($rowN['name2']!=null) echo "<option>".$rowN['name2']."</option>";
         if ($rowN['name3']!=null) echo "<option>".$rowN['name3']."</option>";
         if ($rowN['name4']!=null) echo "<option>".$rowN['name4']."</option>";
         echo "</select></td</tr>";
     }
     else if ($rowN['field_type']=="radio") {
        echo "<tr><td>".$rowN['field_name']."</td><td>";
        if (rowN['name1']!=null) echo "<input type='radio' name='".$rowN['field_name']."' value='".$row['name1']."' checked>".$rowN['name1'];
         if (rowN['name2']!=null) echo "<input type='radio' name='".$rowN['field_name']."' value='".$row['name2']."' checked>".$rowN['name2'];
         if (rowN['name3']!=null) echo "<input type='radio' name='".$rowN['field_name']."' value='".$row['name3']."' checked>".$rowN['name3'];
         if (rowN['name4']!=null) echo "<input type='radio' name='".$rowN['field_name']."' value='".$row['name4']."' checked>".$rowN['name4'];
         echo "</td></tr>";
     }
    else {
echo "<tr><td><label>".$rowN['field_name']."</label></td>";
echo "<td><input type=".$rowN['field_type']." style='width:100%'></input></td></tr>";
    }
 echo "<td><a href='delete.php?field=".$rowN['field_name']."&type=".$rowN['field_type']."'><button>Delete</button></td></tr>";
}
echo "</table><center>"; 
?>
<center><button onclick="document.getElementById('id14').style.display='block'" style="height:50px;width:235px;float:center;">Set Deadline</button></center>
<!-- Add Deadline -->
<div id="id14" class="modal">
  <span onclick="document.getElementById('id14').style.display='none'" 
class="close" title="Close Modal">&times;</span>
<form class="modal-content animate" action="time.php" method="post">
    <div class="container">
    <label><b>Deadline(d-m-y): </b></label>
        <select name='time1' id='time1'><?php for ($i=1;$i<32;$i++) { echo "<option value=".$i.">".$i."</option>"; } ?></select>
       <select name='time2' id='time2'><?php for ($i=1;$i<13;$i++) { echo "<option value=".$i.">".$i."</option>"; } ?></select>
        <select name='time3' id='time3'><?php for ($i=2015;$i<2040;$i++) { echo "<option value=".$i.">".$i."</option>"; } ?></select>
    <br>
    <button type="submit" style="height:27px;width:100%;">Complete</button>
  </div>
</form>
</div>
<!-- -->
<center><button onclick="document.getElementById('id04').style.display='block'" style="height:50px;width:235px;float:center;">Save Form & Get Link</button></center>
<!-- Save Form & Get Link -->
<div id="id04" class="modal">
  <span onclick="document.getElementById('id04').style.display='none'" 
class="close" title="Close Modal">&times;</span>
<form class="modal-content animate" action="login.php" method="post">
    <div class="container">
    <label><b>Form url</b></label>
    <p><a href="final.php?id=<?php session_start(); echo $_SESSION['fid']; ?>">final.php?id=<?php session_start(); echo $_SESSION['fid']; ?></a></p>
    <br>
    <button type="submit" style="height:27px;width:100%;">Complete</button>
  </div>
</form>
</div>
<!-- -->
<?php } ?>
</body>
</html>

