<html>
<head><title>hlo</title><link rel="stylesheet" href="login.css"></head>
<body background="https://st.depositphotos.com/1596326/2653/v/950/depositphotos_26532107-stock-illustration-seamless-rich-floral-background.jpg">

<button onclick="document.getElementById('id03').style.display='block'" style="height:27px;width:10%;float:right;">Sign out</button>
<!--sign out-->
<div id="id03" class="modal">
  <span onclick="document.getElementById('id03').style.display='none'" 
class="close" title="Close Modal">&times;</span>
"<form class="modal-content animate" action="signout.php" method="post">
    <div class="container">
    <label for="uname"><b>Are you sure you want to sign out?</b></label>
    <br>
    <button type="submit" style="height:27px;width:100%;">Yes</button>
  </div>
</form>
</div>

<!----->

<?php
require_once('config.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Start Session
session_start();

if(isset($_POST['submitbtn'])) {
 $sql1 = "select * from myUsers where name='".$_POST['uname']."';";
 $result1 = mysqli_query($conn,$sql1);
 $row1 = mysqli_fetch_array($result1) ;

 //First Login
  if (hash('ripemd160', $_POST['psw'])==$row1['password'] && $_POST['psw']!=null) {  
     //save username
     $_SESSION['user']=$_POST['uname'];
     $_SESSION['userId']=$row1['id'];

    // enter unique no. to table
    $sup="update myUsers set uniqueID=".$_SESSION['rand']." where name='".$_POST['uname']."';";
    if ($conn->query($sup) === FALSE) {  echo "<br>shocking: ".$sup."<br>";   }
  }
}
else
    $sql2 = "select * from myUsers, user_forms, where myUsers.id=user_forms=userId where myUsers.name='".$_SESSION['user']."';";
    $result2 = mysqli_query($conn,$sql2);
    $row2 = mysqli_fetch_array($result2) ;
    if ($_SESSION['rand']==null || $_SESSION['user']==null) { 
    //invalid login
echo "<h2>PLease login first</h2>";
      echo "<a href='wall.php'><h3>Go to Home Page</h3></a>";
    }
    else {
    // refreshing or updating
?>
<div style="background-color:black; color:white; top:0px;">
<p></p>
<p><h1>Welcome <?php session_start(); echo $_SESSION['user'];?> to the Form-Generator</h1></p>
</div>

<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// print user's old forms
echo "<center><h2>Your Forms:</h2>";
$sqlget = "select count(*) from user_forms, myUsers where user_forms.userId=myUsers.id and myUsers.name='".$_SESSION['user']."';";
 $result = mysqli_query($conn, $sqlget);
$row =mysqli_fetch_array($result, MYSQLI_ASSOC);
 echo "<table border='1' bgcolor='#ccffcc' width='700px'>";
if ($row['count(*)']>0) {
 echo "<tr><th>ID</th><th>Form Name</th><th>Form Description</th><th>Form ID</th><th></th></tr>";}
else{
 echo "No forms yet";}
 $i=1;
$sqlget = "select * from user_forms, myUsers where user_forms.userId=myUsers.id and myUsers.name='".$_SESSION['user']."';";
 $result = mysqli_query($conn, $sqlget);
 while($row =mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	if ($row['form_name']!=null) { 
 	echo "<tr><td>";
echo $i;	
        echo "</td><td>";
	echo $row['form_name'];
	echo "</td><td>";
	echo $row['form_desc'];
	echo "</td><td>";
	echo $row['form_id'];
	echo "</td><td>";
	echo "<a href='seeResp.php?id=".$row['formId']."'>View Responses</a>";
	echo "</td></tr>";
     $i+=1;
	}
 }
echo "</table></center>";
?>

<br><center><button onclick="document.getElementById('id06').style.display='block'" style="height:35px;width:25%;">Create New Form</button></center>
<!--create new form-->
<div id="id06" class="modal">
  <span onclick="document.getElementById('id06').style.display='none'" 
class="close" title="Close Modal">&times;</span>
<form class="modal-content animate" action="form.php" method="post">
    <div class="container" style="width:100%;">
 <h2>Create new form:</h2>
  <table class="tabid" style="position:relative;top: -20px; padding:0;">
   <form class="newstuff" action="form.php" method="post" style="text-align: left;"> 
    <tr><td><label for="fname"><b>Name</b></label></td>
         <td><input type="text" placeholder="Name of form" name="fname" style="width:100%;" required></td></tr>
   <?php
session_start();
   $rand=rand();
$_SESSION['fid']=$rand;
  ?>
    <tr><td><label for="fdesc"><b>Description</b></label></td>
    <td><input type="text" placeholder="Describe the form" name="fdesc" style="width:100%;" required></td></tr>
    <tr><td colspan='2'><center><button type="submit" name="submitbtn" style="height:35px;width:100%">Enter</button></center></td></tr>
</form>
  </table>
  </div>
</form>
</div>
<!----->
 
<?php } ?>
</body>
</html>
