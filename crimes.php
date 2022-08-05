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

$maxRows_allcrimesmangement = 10;
$pageNum_allcrimesmangement = 0;
if (isset($_GET['pageNum_allcrimesmangement'])) {
  $pageNum_allcrimesmangement = $_GET['pageNum_allcrimesmangement'];
}
$startRow_allcrimesmangement = $pageNum_allcrimesmangement * $maxRows_allcrimesmangement;

mysql_select_db($database_crimecon, $crimecon);
$query_allcrimesmangement = "SELECT tblcrime.crimeID,  tblcrime.`description`, tblcrime.dateofoffence, tblcrime.dateadded, tblcrime.status, tblsection.sectionnmae, tblresidence.firstname FROM tblcrime, tblsection, tblresidence WHERE tblsection.sectionID = tblcrime.sectionID  AND tblresidence.residenceID = tblcrime.complainerID  AND tblcrime.status = 1";
$query_limit_allcrimesmangement = sprintf("%s LIMIT %d, %d", $query_allcrimesmangement, $startRow_allcrimesmangement, $maxRows_allcrimesmangement);
$allcrimesmangement = mysql_query($query_limit_allcrimesmangement, $crimecon) or die(mysql_error());
$row_allcrimesmangement = mysql_fetch_assoc($allcrimesmangement);

if (isset($_GET['totalRows_allcrimesmangement'])) {
  $totalRows_allcrimesmangement = $_GET['totalRows_allcrimesmangement'];
} else {
  $all_allcrimesmangement = mysql_query($query_allcrimesmangement);
  $totalRows_allcrimesmangement = mysql_num_rows($all_allcrimesmangement);
}
$totalPages_allcrimesmangement = ceil($totalRows_allcrimesmangement/$maxRows_allcrimesmangement)-1;
?>
<?php 

   if(isset($_POST['btnclosecase'])){
    $closeid = $_POST['btnclosecase'];
  
   $close_crime = "UPDATE tblcrime SET status = 0 WHERE crimeID = '$closeid' ";
   if (mysql_query($close_crime)) {
     // code...
    echo '<script>alert ("Crime Close successfuly")</script>';
    header("Location:crimes.php");
   }else{
      echo '<script>alert ("Failed to Close crime")</script>';
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
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>Crime report</title>
</head>
<style type="text/css">

.enrolls-holder{
  width: 80%;
  margin-left: 10%;
  display: flex;
    flex-wrap: wrap;
    justify-content: center;
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
   	</div>
   </div>
   </nav>
   <hr>
      
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="#">Username</a> -->

      <li class="nav-item dropdown">
          <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Username
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="crimes.php">Profile</a></li>
            <li><a class="dropdown-item" href="victims.php">User Guide </a></li>
            <li><a class="dropdown-item" href="suspects.php">Logout</a></li>
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
          <a class="nav-link" href="#">All Users</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<!-- start of body -->

<!-- Analysis of crime -->
<label>Analysis</label><br>
<!-- end of analysis -->


<!-- other display -->
<label>Tables of data</label>
<!-- end of other display -->


<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">Availlable Constituencies <span></span></label>
    </div>
    <table>
      <thead>
  <tr>
    <th>ID</th>
    <th>Section</th>
    <th>Description</th>
    <th>Date of offence</th>
    <th>Date Added</th>
    <th>Complainer</th>
    <th>Status</th>
    
  </tr>
  </thead>
  <tbody>
    
<?php do { ?>
    <tr>
      <td><?php echo $row_allcrimesmangement['crimeID']; ?></td>
      <td><?php echo $row_allcrimesmangement['sectionnmae']; ?></td>
      <td><?php echo $row_allcrimesmangement['description']; ?></td>
      <td><?php echo $row_allcrimesmangement['dateofoffence']; ?></td>
      <td><?php echo $row_allcrimesmangement['dateadded']; ?></td>
      <td><?php echo $row_allcrimesmangement['firstname']; ?></td>
      <td><?php   if($row_allcrimesmangement['status'] == 1){
        echo "Active";
      }else{
        echo "Closed";
      } ?></td>
      <td><form action="crimes.php" method="POST" name="formclosecrime" id="closecrime1"> <button class="mybutton-small" value="<?php echo $row_allcrimesmangement['crimeID']; ?>" name="btnclosecase">Close</button>
      </form>
    </td>
      
    </tr>
    <?php } while ($row_allcrimesmangement = mysql_fetch_assoc($allcrimesmangement)); ?>
    </tbody>
</table>
  </div>
  </div>



<!-- end of body -->
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
mysql_free_result($allcrimesmangement);
?>
