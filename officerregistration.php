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
   $accountType = "admin";
  $insertSQL = sprintf("INSERT INTO tblofficers (firstname, othername, phone, email, gender, officernumber, departmentID, workstationID, dateadded, dateupdated, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['othername'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['officernumber'], "int"),
                       GetSQLValueString($_POST['departmentID'], "int"),
                       GetSQLValueString($_POST['workstationID'], "int"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['dateadded'], "date"));



$insertSQLUser = sprintf("INSERT INTO tblusers (username, password, privillage) VALUES (%s, %s, '{$accountType}')",
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['officernumber'], "text"));
                       

 
  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());

   mysql_select_db($database_crimecon, $crimecon);
  $Result2 = mysql_query($insertSQLUser, $crimecon) or die(mysql_error());


}

$maxRows_alldepartmentofficer = 10;
$pageNum_alldepartmentofficer = 0;
if (isset($_GET['pageNum_alldepartmentofficer'])) {
  $pageNum_alldepartmentofficer = $_GET['pageNum_alldepartmentofficer'];
}
$startRow_alldepartmentofficer = $pageNum_alldepartmentofficer * $maxRows_alldepartmentofficer;

mysql_select_db($database_crimecon, $crimecon);
$query_alldepartmentofficer = "SELECT tbldepartment.departmentId, tbldepartment.departmentName FROM tbldepartment WHERE tbldepartment.status =1";
$query_limit_alldepartmentofficer = sprintf("%s LIMIT %d, %d", $query_alldepartmentofficer, $startRow_alldepartmentofficer, $maxRows_alldepartmentofficer);
$alldepartmentofficer = mysql_query($query_limit_alldepartmentofficer, $crimecon) or die(mysql_error());
$row_alldepartmentofficer = mysql_fetch_assoc($alldepartmentofficer);

if (isset($_GET['totalRows_alldepartmentofficer'])) {
  $totalRows_alldepartmentofficer = $_GET['totalRows_alldepartmentofficer'];
} else {
  $all_alldepartmentofficer = mysql_query($query_alldepartmentofficer);
  $totalRows_alldepartmentofficer = mysql_num_rows($all_alldepartmentofficer);
}
$totalPages_alldepartmentofficer = ceil($totalRows_alldepartmentofficer/$maxRows_alldepartmentofficer)-1;

mysql_select_db($database_crimecon, $crimecon);
$query_allworkstationcode = "SELECT tblworkstation.workstationID, tblworkstation.workstation FROM tblworkstation WHERE tblworkstation.status =1  ";
$allworkstationcode = mysql_query($query_allworkstationcode, $crimecon) or die(mysql_error());
$row_allworkstationcode = mysql_fetch_assoc($allworkstationcode);
$totalRows_allworkstationcode = mysql_num_rows($allworkstationcode);

$maxRows_AllOfficers = 10;
$pageNum_AllOfficers = 0;
if (isset($_GET['pageNum_AllOfficers'])) {
  $pageNum_AllOfficers = $_GET['pageNum_AllOfficers'];
}
$startRow_AllOfficers = $pageNum_AllOfficers * $maxRows_AllOfficers;

mysql_select_db($database_crimecon, $crimecon);
$query_AllOfficers = "SELECT tblofficers.email, tblofficers.firstname, tblofficers.phone, tblofficers.status, tbldepartment.departmentName, tblworkstation.workstation FROM tblofficers, tblworkstation, tbldepartment WHERE tblworkstation.workstationID = tblofficers.workstationID AND tbldepartment.departmentId = tblofficers.departmentID";
$query_limit_AllOfficers = sprintf("%s LIMIT %d, %d", $query_AllOfficers, $startRow_AllOfficers, $maxRows_AllOfficers);
$AllOfficers = mysql_query($query_limit_AllOfficers, $crimecon) or die(mysql_error());
$row_AllOfficers = mysql_fetch_assoc($AllOfficers);

if (isset($_GET['totalRows_AllOfficers'])) {
  $totalRows_AllOfficers = $_GET['totalRows_AllOfficers'];
} else {
  $all_AllOfficers = mysql_query($query_AllOfficers);
  $totalRows_AllOfficers = mysql_num_rows($all_AllOfficers);
}
$totalPages_AllOfficers = ceil($totalRows_AllOfficers/$maxRows_AllOfficers)-1;
?>

<?php 

   if(isset($_POST['btndisableofficer'])){
    $closeid = $_POST['btndisableofficer'];
  
   $close_Account = "UPDATE tblofficers SET status = 0 WHERE email = '$closeid' ";
   if (mysql_query($close_Account)) {
     // code...
    echo '<script>alert ("Officer Disabled successfuly")</script>';
    header("Location:officerregistration.php");
   }else{
      echo '<script>alert ("Failed to Disable")</script>';
   }

   mysql_query($close_crime) or die(mysql_error());

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
<title>Officer Registration</title>
<style type="text/css">
  .myActionbutton{
  background: dodgerblue;
  color: white;
  font-size: 18px;
  border-radius: 5px;
  outline: none;
  border: none;
}
</style>
</head>
<body>

  <nav class="shadow-lg p-3 mb-5 bg-body rounded">
   <div class="logoholder">
    <div class="logo-holder">
      <img src="assets/logo/logo.png">
    </div>
    <div class="name-holder">
      <h3>Bungoma county crime logger</h3>
    </div>
   </div>
   </nav>
   <hr>
      
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="#">Username</a> -->

      <li class="nav-item dropdown">
          <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['username'] ?> </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="adminusermanual.php">User Guide </a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="dashboardadmin.php">Dashboard</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Crimes/Case
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="crimes.php">Crimes</a></li>
            <li><a class="dropdown-item" href="victims.php">Victims</a></li>
            <li><a class="dropdown-item" href="suspects.php">Suspects</a></li>
            <li><a class="dropdown-item" href="witness.php">Witness</a></li>
            <li><a class="dropdown-item" href="addcrimesection.php">Add Section</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Officers
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="officerregistration.php">Add Officer</a></li>
            <li><a class="dropdown-item" href="adddepartment.php">Add Department</a></li>
            <li><a class="dropdown-item" href="addworkstation.php">Add WorkStation</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Location
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="addcounty.php">Add County</a></li>
            <li><a class="dropdown-item" href="addconstituency.php">Add Constituency</a></li>
            <li><a class="dropdown-item" href="addwards.php">Add Wards</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="systemusers.php">All Users</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
 

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="firstname" value="" class="myinputtext" placeholder="First name" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="othername" value="" class="myinputtext" placeholder="Other name" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="phone" value="" class="myinputtext" placeholder="071234..." /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="email" value="" class="myinputtext" placeholder="Enter email" /></td>
    </tr>
    <tr valign="baseline">
      <td>
         <select  name="gender" class="myoption">
         	<option>Select Gender</option>
         	<option>MALE</option>
         	<option>FEMALE</option>
         </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="officernumber" value="" class="myinputtext" placeholder="Enter Id number" /></td>
    </tr>
    <tr valign="baseline">
      <td>
        <select  name="departmentID" class="myoption">
          <?php
do {  
?>
          <option value="<?php echo $row_alldepartmentofficer['departmentId']?>"<?php if (!(strcmp($row_alldepartmentofficer['departmentId'], $row_alldepartmentofficer['departmentId']))) {echo "selected=\"selected\"";} ?>><?php echo $row_alldepartmentofficer['departmentName']?></option>
          <?php
} while ($row_alldepartmentofficer = mysql_fetch_assoc($alldepartmentofficer));
  $rows = mysql_num_rows($alldepartmentofficer);
  if($rows > 0) {
      mysql_data_seek($alldepartmentofficer, 0);
	  $row_alldepartmentofficer = mysql_fetch_assoc($alldepartmentofficer);
  }
?>
        </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td>
      
      <select name="workstationID" class="myoption">
        <?php
do {  
?>
        <option value="<?php echo $row_allworkstationcode['workstationID']?>"<?php if (!(strcmp($row_allworkstationcode['workstationID'], $row_allworkstationcode['workstationID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_allworkstationcode['workstation']?></option>
        <?php
} while ($row_allworkstationcode = mysql_fetch_assoc($allworkstationcode));
  $rows = mysql_num_rows($allworkstationcode);
  if($rows > 0) {
      mysql_data_seek($allworkstationcode, 0);
	  $row_allworkstationcode = mysql_fetch_assoc($allworkstationcode);
  }
?>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="date" name="dateadded" value="" class="myinputtext" /></td>
    </tr>
   
   
    <tr valign="baseline">
      <td><input type="submit" value="Add New Officer"  class="mybutton" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>

<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">Availlable Constituencies <span></span></label>
    </div>
<table>
  <thead>
  <tr>
    <th>Email</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Department</th>
    <th>Workstation</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_AllOfficers['email']; ?></td>
      <td><?php echo $row_AllOfficers['firstname']; ?></td>
      <td><?php echo $row_AllOfficers['phone']; ?></td>
      <td><?php echo $row_AllOfficers['departmentName']; ?></td>
      <td><?php echo $row_AllOfficers['workstation']; ?></td>
      <td><?php  if ($row_AllOfficers['status'] == 1){
         echo "Active";
      }else{
        echo "Account Closed";
      }  
    ?></td>
    <td>
      
      <form action="officerregistration.php" method="POST" name="formdiasbleofficer" id="disableoffiser1"> <button class="myActionbutton" value="<?php echo $row_AllOfficers['email']; ?>" name="btndisableofficer">Disable</button>
      </form>

    </td>
    </tr>
    <?php } while ($row_AllOfficers = mysql_fetch_assoc($AllOfficers)); ?>

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
mysql_free_result($alldepartmentofficer);

mysql_free_result($allworkstationcode);

mysql_free_result($AllOfficers);
?>
