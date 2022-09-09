<?php require_once('Connections/crimecon.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
  session_start();
if(isset($_POST['btnlogin'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query="SELECT username,privillage FROM tblusers WHERE username='$username' AND password='$password'"; 
   $check=mysql_query($query);
   $num_rows=mysql_num_rows($check);

  if($num_rows){
   $row=mysql_fetch_assoc($check);
  $_SESSION['username'] = $row['username'];
  $_SESSION['privillage'] = $row['privillage'];
   
   if($_SESSION['privillage'] == "user"){
   header("Refresh:1; url=userdashboard.php");

  }

  if($_SESSION['privillage'] == "admin"){
   header("Location:dashboardadmin.php");

  }
  if($_SESSION['privillage'] == "none"){
   echo '<script>alert ("Your account was Disable")</script>';

  }

  }


}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>Login crime log</title>
</head>
<style type="text/css">
nav{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  transition: all 0.4s ease;
  z-index: 1000;
}

.name-holder a{
    text-decoration: none;
    font-size: 18px;
    padding-left: 8px;
    padding-right: 8px;
    border-bottom: 3px solid white;
    transition: border-bottom 2s;
}
.name-holder a:hover{
    text-decoration: none;
    font-size: 18px;
    padding-left: 8px;
    padding-right: 8px;
    border-bottom: 3px solid dodgerblue;
}


</style>
<body>

<nav class="shadow-lg p-3 mb-5 bg-body rounded">
   <div class="logoholder">
    <div class="logo-holder">
      <img src="assets/logo/logo.png">
    </div>
    <div class="name-holder">
      <h3>Bungoma county crime logger</h3>
        <a href="index.php">Back</a>
        <a href="addresidence.php">Register</a>
    </div>
   </div>
   </nav>

<br><br><br><br><br>
<br><br><br><br>

<form action="login.php" method="POST" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="username" value="" class="myinputtext" placeholder="Enter username" /></td>
    </tr>
   
    <tr valign="baseline">
      <td><input type="password" name="password" value="" class="myinputtext" placeholder="*********" /></td>
    </tr>
   <tr valign="baseline">
      <td><br><input type="checkbox" name="showpassword" value="Show password" />
        <label form="showpassword">Show password</label>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="submit" value="Login now"  class="mybutton" name="btnlogin" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

<br><br>

 <div class="footer-dark">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Services</h3>
                        <ul>
                            <li><a href="#">Crime reporting</a></li>
                            <li><a href="#">Crime alerts</a></li>
                            <li><a href="#">Danger Zone </a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>About</h3>
                        <ul>
                            <li><a href="#">Police</a></li>
                            <li><a href="#">CID</a></li>
                            <li><a href="#">DCI</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 item text">
                        <h3>Bungoma  Crime Logger</h3>
                       <p>This is bungoma county crime reporting system that aid in capturing crime details reported by residence to tha law enforcers.</p>
                    </div>
                    
                </div>
                <p class="copyright">Bungoma  Crime Logger &copy; 2022</p>
            </div>
        </footer>
    </div>


</body>
</html>

