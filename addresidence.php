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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tblresidence (residenceIdNumber, firstname, othername, gender, phone, email, countyID, consituencyID, wardID, village, photo, datecreated, dateupdated, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 0, %s, %s, 1)",
                       GetSQLValueString($_POST['residenceIdNumber'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['othername'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['countyID'], "int"),
                       GetSQLValueString($_POST['consituencyID'], "int"),
                       GetSQLValueString($_POST['wardID'], "int"),
                       GetSQLValueString($_POST['village'], "text"),
                       GetSQLValueString($_POST['datecreated'], "date"),
                       GetSQLValueString($_POST['datecreated'], "date"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

mysql_select_db($database_crimecon, $crimecon);
$query_cmbcounty = "SELECT tblcounty.countyID, tblcounty.countyname FROM tblcounty WHERE tblcounty.status =1";
$cmbcounty = mysql_query($query_cmbcounty, $crimecon) or die(mysql_error());
$row_cmbcounty = mysql_fetch_assoc($cmbcounty);
$totalRows_cmbcounty = mysql_num_rows($cmbcounty);

mysql_select_db($database_crimecon, $crimecon);
$query_cmbconstituency = "SELECT tblconstituency.constituencyID, tblconstituency.constituencyname FROM tblconstituency WHERE tblconstituency.status = 1";
$cmbconstituency = mysql_query($query_cmbconstituency, $crimecon) or die(mysql_error());
$row_cmbconstituency = mysql_fetch_assoc($cmbconstituency);
$totalRows_cmbconstituency = mysql_num_rows($cmbconstituency);

mysql_select_db($database_crimecon, $crimecon);
$query_cmbward = "SELECT tblward.wardID, tblward.wardname FROM tblward WHERE tblward.status =1";
$cmbward = mysql_query($query_cmbward, $crimecon) or die(mysql_error());
$row_cmbward = mysql_fetch_assoc($cmbward);
$totalRows_cmbward = mysql_num_rows($cmbward);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>Residence Registration</title>
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
        <a href="login.php">Login</a>
    </div>
   </div>
   </nav>

<br><br><br><br><br>
<br><br><br><br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="residenceIdNumber" value="" class="myinputtext" placeholder="Enter ID Number" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="firstname" value="" class="myinputtext" placeholder="First Name" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="othername" value="" class="myinputtext" placeholder="Other name" /></td>
    </tr>
    <tr valign="baseline">
      <td>
        <select name="gender" class="myoption">
          <option>Select Gender</option>
          <option>MALE</option>
          <option>FEMALE</option>
        </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="phone" value="" class="myinputtext" placeholder="Phone number" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="email" value="" class="myinputtext" placeholder="Enter email" /></td>
    </tr>
    <tr valign="baseline">
      
      <td>
      <select name="countyID" class="myoption">
        <?php
do {  
?>
        <option value="<?php echo $row_cmbcounty['countyID']?>"<?php if (!(strcmp($row_cmbcounty['countyID'], $row_cmbcounty['countyID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_cmbcounty['countyname']?></option>
        <?php
} while ($row_cmbcounty = mysql_fetch_assoc($cmbcounty));
  $rows = mysql_num_rows($cmbcounty);
  if($rows > 0) {
      mysql_data_seek($cmbcounty, 0);
	  $row_cmbcounty = mysql_fetch_assoc($cmbcounty);
  }
?>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
     
      <td>
      <select name="consituencyID" class="myoption">
        <?php
do {  
?>
        <option value="<?php echo $row_cmbconstituency['constituencyID']?>"<?php if (!(strcmp($row_cmbconstituency['constituencyID'], $row_cmbconstituency['constituencyID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_cmbconstituency['constituencyname']?></option>
        <?php
} while ($row_cmbconstituency = mysql_fetch_assoc($cmbconstituency));
  $rows = mysql_num_rows($cmbconstituency);
  if($rows > 0) {
      mysql_data_seek($cmbconstituency, 0);
	  $row_cmbconstituency = mysql_fetch_assoc($cmbconstituency);
  }
?>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
     
      <td>
           <select name="wardID" class="myoption">
             <?php
do {  
?>
             <option value="<?php echo $row_cmbward['wardID']?>"<?php if (!(strcmp($row_cmbward['wardID'], $row_cmbward['wardID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_cmbward['wardname']?></option>
             <?php
} while ($row_cmbward = mysql_fetch_assoc($cmbward));
  $rows = mysql_num_rows($cmbward);
  if($rows > 0) {
      mysql_data_seek($cmbward, 0);
	  $row_cmbward = mysql_fetch_assoc($cmbward);
  }
?>
           </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="village" value="" class="myinputtext" placeholder="Place of Residence/town/village" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="date" name="datecreated" value="" class="myinputtext" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="password" name="password" value="" class="myinputtext" placeholder="********" onkeyup="validatepassword()" id="checkpassword" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="checkbox" name="" > &nbsp;Show password</td>
    </tr>
    <tr valign="baseline">
      
      <td><input type="submit" value="Register now" class="mybutton"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>

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
                        <p>Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p>
                    </div>
                    
                </div>
                <p class="copyright">Bungoma  Crime Logger &copy; 2022</p>
            </div>
        </footer>
    </div>

<script type="text/javascript" src="customjs/registervalidation.js"></script>
</body>
</html>
<?php
mysql_free_result($cmbcounty);

mysql_free_result($cmbconstituency);

mysql_free_result($cmbward);
?>
