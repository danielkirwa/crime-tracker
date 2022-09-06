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

$maxRows_AllusersinSystem = 10;
$pageNum_AllusersinSystem = 0;
if (isset($_GET['pageNum_AllusersinSystem'])) {
  $pageNum_AllusersinSystem = $_GET['pageNum_AllusersinSystem'];
}
$startRow_AllusersinSystem = $pageNum_AllusersinSystem * $maxRows_AllusersinSystem;

mysql_select_db($database_crimecon, $crimecon);
$query_AllusersinSystem = "SELECT tblresidence.email, tblresidence.phone, tblresidence.status FROM tblresidence";
$query_limit_AllusersinSystem = sprintf("%s LIMIT %d, %d", $query_AllusersinSystem, $startRow_AllusersinSystem, $maxRows_AllusersinSystem);
$AllusersinSystem = mysql_query($query_limit_AllusersinSystem, $crimecon) or die(mysql_error());
$row_AllusersinSystem = mysql_fetch_assoc($AllusersinSystem);

if (isset($_GET['totalRows_AllusersinSystem'])) {
  $totalRows_AllusersinSystem = $_GET['totalRows_AllusersinSystem'];
} else {
  $all_AllusersinSystem = mysql_query($query_AllusersinSystem);
  $totalRows_AllusersinSystem = mysql_num_rows($all_AllusersinSystem);
}
$totalPages_AllusersinSystem = ceil($totalRows_AllusersinSystem/$maxRows_AllusersinSystem)-1;

mysql_select_db($database_crimecon, $crimecon);
$query_AllOfficers = "SELECT tblofficers.email, tblofficers.firstname, tblofficers.phone, tblofficers.status, tbldepartment.departmentName, tblworkstation.workstation FROM tblofficers, tblworkstation, tbldepartment WHERE tblworkstation.workstationID = tblofficers.workstationID AND tbldepartment.departmentId = tblofficers.departmentID";
$AllOfficers = mysql_query($query_AllOfficers, $crimecon) or die(mysql_error());
$row_AllOfficers = mysql_fetch_assoc($AllOfficers);
$totalRows_AllOfficers = mysql_num_rows($AllOfficers);
?>

<?php 

   if(isset($_POST['btndelete'])){
    $useremail = $_POST['btndelete'];
  
   $close_user = "UPDATE tblresidence SET status = 0 WHERE email = '$useremail' ";
   if (mysql_query($close_user)) {
     // code...
    echo '<script>alert ("User deleted successfuly")</script>';
    header("Location:systemusers.php");
   }else{
      echo '<script>alert ("Failed to delete User")</script>';
   }

   mysql_query($close_user) or die(mysql_error());

}
 ?>

 <?php 

   if(isset($_POST['btndisableofficer'])){
    $closeid = $_POST['btndisableofficer'];
  
   $close_Account = "UPDATE tblofficers SET status = 0 WHERE email = '$closeid' ";
   if (mysql_query($close_Account)) {
     // code...
    echo '<script>alert ("Officer Disabled successfuly")</script>';
    header("Location:systemusers.php");
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
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/admin.css">
<link rel="stylesheet" type="text/css" href="customcss/popupanalysis.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>All users</title>
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
            <?php echo $_SESSION['username'] ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="advice.php">Advice</a></li>
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
            <li><a class="dropdown-item" href="officers.php">Add Officer</a></li>
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

<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">Availlable Officers <span></span></label>
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




<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">All users/ Residence <span></span></label>
    </div>
    <table>
      <thead>
  <tr>
    <th>Email</th>
    <th>Phone</th>
    <th>Status</th>
    <th>Action</th>

  </tr>
  </thead>
  <tbody>
    
 <?php do { ?>
          <tr>
            <td><?php echo $row_AllusersinSystem['email']; ?></td>
            <td><?php echo $row_AllusersinSystem['phone']; ?></td>
            <td><?php if ($row_AllusersinSystem['status'] == 1) {
            	echo "Active";
            }else{
            	echo "Account closed";
            } ?></td>
            <td><form action="systemusers.php" method="POST" name="formclosecrime" id="closecrime1"> <button class="myActionbutton" value="<?php echo $row_AllusersinSystem['email']; ?>" name="btndelete">Close</button>
      </form></td>

          </tr>
          <?php } while ($row_AllusersinSystem = mysql_fetch_assoc($AllusersinSystem)); ?>
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
                        <p>This is bungoma county crime reporting system that aid in capturing crime details reported by residence to tha law enforcers.</p>
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
mysql_free_result($AllusersinSystem);

mysql_free_result($AllOfficers);
?>
