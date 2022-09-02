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

$maxRows_AllVictims = 10;
$pageNum_AllVictims = 0;
if (isset($_GET['pageNum_AllVictims'])) {
  $pageNum_AllVictims = $_GET['pageNum_AllVictims'];
}
$startRow_AllVictims = $pageNum_AllVictims * $maxRows_AllVictims;

mysql_select_db($database_crimecon, $crimecon);
$query_AllVictims = "SELECT tblvictim.victimID,  tblvictim.firstname, tblvictim.phone, tblward.wardname,tblvictim.crimeID, tblsection.sectionnmae,tblvictim.status, tblvictim.dateadded FROM tblvictim, tblward, tblcrime, tblsection WHERE tblward.wardID = tblvictim.wardid  AND tblcrime.crimeID = tblvictim.crimeID   AND tblsection.sectionID= tblcrime.sectionID  AND tblvictim.status = 1 ORDER BY tblvictim.dateadded DESC";
$query_limit_AllVictims = sprintf("%s LIMIT %d, %d", $query_AllVictims, $startRow_AllVictims, $maxRows_AllVictims);
$AllVictims = mysql_query($query_limit_AllVictims, $crimecon) or die(mysql_error());
$row_AllVictims = mysql_fetch_assoc($AllVictims);

if (isset($_GET['totalRows_AllVictims'])) {
  $totalRows_AllVictims = $_GET['totalRows_AllVictims'];
} else {
  $all_AllVictims = mysql_query($query_AllVictims);
  $totalRows_AllVictims = mysql_num_rows($all_AllVictims);
}
$totalPages_AllVictims = ceil($totalRows_AllVictims/$maxRows_AllVictims)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>Victims</title>
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
 

<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">Availlable Active Victime <span></span></label>
    </div>
<table>
  <thead>
  <tr>
    <th>Victim ID</th>
    <th>First Name</th>
    <th>Phone</th>
    <th>Ward Name</th>
    <th>Crime ID</th>
    <th>Section Name</th>
    <th>Date Added</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
    <?php do { ?>
    <tr>
      <td><?php echo $row_AllVictims['victimID']; ?></td>
      <td><?php echo $row_AllVictims['firstname']; ?></td>
      <td><?php echo $row_AllVictims['phone']; ?></td>
      <td><?php echo $row_AllVictims['wardname']; ?></td>
      <td><?php echo $row_AllVictims['crimeID']; ?></td>
      <td><?php echo $row_AllVictims['sectionnmae']; ?></td>
      <td><?php echo $row_AllVictims['dateadded']; ?></td>
      <td><?php  if ($row_AllVictims['status'] == 1) {
        // code...
        echo "Active";
      }else{
        echo "Not Active";
      } ?></td>
      
      <td>
        <form action="victims.php" method="POST" name="formdiasblevictime" id="disablevictim1"> <button class="myActionbutton" value="<?php echo $row_AllVictims['victimID']; ?>" name="btndisablevictim">Disable</button>
      </form>
      </td>
    </tr>
    <?php } while ($row_AllVictims = mysql_fetch_assoc($AllVictims)); ?>

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

</body>
</html>
<?php
mysql_free_result($AllVictims);
?>
