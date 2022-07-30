<?php require_once('Connections/crimecon.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

if ($_SESSION['username']) {
  // code...
 $currentUser =   $_SESSION['username'];
}else{
    header("Location:login.php");
}

?>

<?php 
$CrimeID = $_GET['editcaseid'];
 ?>

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
  $insertSQL = sprintf("INSERT INTO tblsuspect (crimeID,firstname, othername, gender, age, decription, countyID, consituencyID, wardID, dateadded, dateupdated, status) VALUES (%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['crimeid'], "text"),
					   GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['othername'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['age'], "int"),
                       GetSQLValueString($_POST['decription'], "text"),
                       GetSQLValueString($_POST['countyID'], "int"),
                       GetSQLValueString($_POST['consituencyID'], "int"),
                       GetSQLValueString($_POST['wardID'], "int"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['dateadded'], "date"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

mysql_select_db($database_crimecon, $crimecon);
$query_cmbcounty = "SELECT tblcounty.countyID, tblcounty.countyname FROM tblcounty WHERE tblcounty.status = 1";
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

$maxRows_postedsuspects = 10;
$pageNum_postedsuspects = 0;
if (isset($_GET['pageNum_postedsuspects'])) {
  $pageNum_postedsuspects = $_GET['pageNum_postedsuspects'];
}
$startRow_postedsuspects = $pageNum_postedsuspects * $maxRows_postedsuspects;

mysql_select_db($database_crimecon, $crimecon);
$query_postedsuspects = "SELECT  tblsuspect.suspectID, tblcrime.crimeID,  tblsection.sectionnmae, tblsuspect.firstname, tblsuspect.dateadded FROM tblcrime, tblsection, tblsuspect WHERE tblsuspect.crimeID = tblcrime.crimeID  AND tblsection.sectionID = tblcrime.sectionID  AND tblcrime.complainerID = 1 ";
$query_limit_postedsuspects = sprintf("%s LIMIT %d, %d", $query_postedsuspects, $startRow_postedsuspects, $maxRows_postedsuspects);
$postedsuspects = mysql_query($query_limit_postedsuspects, $crimecon) or die(mysql_error());
$row_postedsuspects = mysql_fetch_assoc($postedsuspects);

if (isset($_GET['totalRows_postedsuspects'])) {
  $totalRows_postedsuspects = $_GET['totalRows_postedsuspects'];
} else {
  $all_postedsuspects = mysql_query($query_postedsuspects);
  $totalRows_postedsuspects = mysql_num_rows($all_postedsuspects);
}
$totalPages_postedsuspects = ceil($totalRows_postedsuspects/$maxRows_postedsuspects)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>Suspect</title>
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






</style>
<body>

<nav class="shadow-lg p-3 mb-5 bg-body rounded">
   <div class="logoholder">
    <div class="logo-holder">
      <img src="assets/logo/logo.png">
    </div>
    <div class="name-holder">
      <h3 class="dodgerblueText">Bungoma county crime logger</h3>
      <div class="my-nav-holder">
      

           <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="#">Username</a> -->

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Report
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="addcrime.php">Crimes</a></li>
            <li><a class="dropdown-item" href="usercrimereport.php">View crime</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="userdashboard.php">Home</a>
        </li>

        

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['username'] ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="userprofile.php">Profile</a></li>
            <li><a class="dropdown-item" href="usermanual.php">User manual</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>

        
      </ul>
 
    </div>
  </div>
</nav>


      </div>
    </div>
   </div>
   </nav>
   <br><br><br><br><br><br><br><br>
   <hr>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <center><label class="largeText dodgerblueText">Suspect form fill and submit</label></center>
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" value="<?php echo $CrimeID;  ?>" class="myinputtext" placeholder="Crime ID" name="crimeid"/></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="firstname" value="" class="myinputtext" placeholder="First name" /></td>
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
      <td><input type="text" name="age" value="" class="myinputtext" placeholder="Estimated age" /></td>
    </tr>
    <tr valign="baseline">
      <td>
       <textarea name="decription" placeholder="Suspect decription" class="myinputtext">
         
       </textarea>
      </td>
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
      <td><input type="date" name="dateadded" value="" class="myinputtext"  /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="submit" value="Add Suspect"  class="mybutton" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>


<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">All posted Suspects<span></span></label>
    </div>
    
<table>
    <thead>
  <tr>
    <th>Suspect ID</th>
    <th>Crime ID</th>
    <th>Section Name</th>
    <th>First Name</th>
    <th>Date Added</th>

  </tr>
</thead>
<tbody>
 </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_postedsuspects['suspectID']; ?></td>
      <td><?php echo $row_postedsuspects['crimeID']; ?></td>
      <td><?php echo $row_postedsuspects['sectionnmae']; ?></td>
      <td><?php echo $row_postedsuspects['firstname']; ?></td>
      <td><?php echo $row_postedsuspects['dateadded']; ?></td>
    </tr>
    <?php } while ($row_postedsuspects = mysql_fetch_assoc($postedsuspects)); ?>
</tbody>
</table>
  </div>
  </div>








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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
<?php
mysql_free_result($cmbcounty);

mysql_free_result($cmbconstituency);

mysql_free_result($cmbward);

mysql_free_result($postedsuspects);
?>
