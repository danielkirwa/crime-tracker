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

$maxRows_AllSuspects = 10;
$pageNum_AllSuspects = 0;
if (isset($_GET['pageNum_AllSuspects'])) {
  $pageNum_AllSuspects = $_GET['pageNum_AllSuspects'];
}
$startRow_AllSuspects = $pageNum_AllSuspects * $maxRows_AllSuspects;

mysql_select_db($database_crimecon, $crimecon);
$query_AllSuspects = "SELECT tblsuspect.suspectID, tblsuspect.crimeID, tblsuspect.firstname, tblsuspect.dateadded, tblsuspect.status, tblsection.sectionnmae, tblward.wardname FROM tblsuspect, tblcrime, tblsection, tblward WHERE  tblcrime.crimeID = tblsuspect.crimeID AND tblsection.sectionID = tblcrime.sectionID  AND tblward.wardID = tblsuspect.wardID  AND tblsuspect.status = 1";
$query_limit_AllSuspects = sprintf("%s LIMIT %d, %d", $query_AllSuspects, $startRow_AllSuspects, $maxRows_AllSuspects);
$AllSuspects = mysql_query($query_limit_AllSuspects, $crimecon) or die(mysql_error());
$row_AllSuspects = mysql_fetch_assoc($AllSuspects);

if (isset($_GET['totalRows_AllSuspects'])) {
  $totalRows_AllSuspects = $_GET['totalRows_AllSuspects'];
} else {
  $all_AllSuspects = mysql_query($query_AllSuspects);
  $totalRows_AllSuspects = mysql_num_rows($all_AllSuspects);
}
$totalPages_AllSuspects = ceil($totalRows_AllSuspects/$maxRows_AllSuspects)-1;
?>

<?php 

   if(isset($_POST['btndisablesuspects'])){
    $closeid = $_POST['btndisablesuspects'];
  
   $close_crime = "UPDATE tblsuspect SET status = 0 WHERE suspectID = '$closeid' ";
   if (mysql_query($close_crime)) {
     // code...
    echo '<script>alert ("Suspects Released successfuly")</script>';
    header("Location:suspects.php");
   }else{
      echo '<script>alert ("Failed To Released Suspects")</script>';
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
<title>Suspects</title>
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


<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">Availlable Active Victime <span></span></label>
    </div>
<table>
  <thead>
  <tr>
    <td>Suspect ID</td>
    <td>First Name</td>
    <td>Date added</td>
    <td>Crime ID</td>
    <td>Section</td>
    <td>Ward Name</td>
    <td>Status</td>
    <td>Action</td>
  </tr>
  </thead>
  <tbody>
    <?php do { ?>
    <tr>
      <td><?php echo $row_AllSuspects['suspectID']; ?></td>
      <td><?php echo $row_AllSuspects['firstname']; ?></td>
      <td><?php echo $row_AllSuspects['dateadded']; ?></td>
      <td><?php echo $row_AllSuspects['crimeID']; ?></td>
      <td><?php echo $row_AllSuspects['sectionnmae']; ?></td>
      <td><?php echo $row_AllSuspects['wardname']; ?></td>
      <td><?php  if ($row_AllSuspects['status'] == 1) {
        // code...
        echo "Active";
      }else{
        echo "Innocent";
      } ?></td>
      
      <td>
        <form action="suspects.php" method="POST" name="formdiasblesuspects" id="disablesuspects1"> <button class="myActionbutton" value="<?php echo $row_AllSuspects['suspectID']; ?>" name="btndisablesuspects">Disable</button>
      </form>
      </td>
    </tr>
     <?php } while ($row_AllSuspects = mysql_fetch_assoc($AllSuspects)); ?>

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
mysql_free_result($AllSuspects);
?>
