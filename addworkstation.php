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
  $insertSQL = sprintf("INSERT INTO tblworkstation (workstation, `description`, dateadded, dateupdated, departmentID, status) VALUES (%s, %s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['workstation'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['departmentID'], "int"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

mysql_select_db($database_crimecon, $crimecon);
$query_comdepartments = "SELECT tbldepartment.departmentId, tbldepartment.departmentName FROM tbldepartment WHERE tbldepartment.status = 1";
$comdepartments = mysql_query($query_comdepartments, $crimecon) or die(mysql_error());
$row_comdepartments = mysql_fetch_assoc($comdepartments);
$totalRows_comdepartments = mysql_num_rows($comdepartments);

$maxRows_allworkstation = 10;
$pageNum_allworkstation = 0;
if (isset($_GET['pageNum_allworkstation'])) {
  $pageNum_allworkstation = $_GET['pageNum_allworkstation'];
}
$startRow_allworkstation = $pageNum_allworkstation * $maxRows_allworkstation;

mysql_select_db($database_crimecon, $crimecon);
$query_allworkstation = "SELECT tbldepartment.departmentName, tblworkstation.workstationID, tblworkstation.workstation, tblworkstation.`description`, tblworkstation.dateadded, tblworkstation.dateupdated, tblworkstation.status FROM tblworkstation, tbldepartment WHERE tbldepartment.departmentId = tblworkstation.departmentID";
$query_limit_allworkstation = sprintf("%s LIMIT %d, %d", $query_allworkstation, $startRow_allworkstation, $maxRows_allworkstation);
$allworkstation = mysql_query($query_limit_allworkstation, $crimecon) or die(mysql_error());
$row_allworkstation = mysql_fetch_assoc($allworkstation);

if (isset($_GET['totalRows_allworkstation'])) {
  $totalRows_allworkstation = $_GET['totalRows_allworkstation'];
} else {
  $all_allworkstation = mysql_query($query_allworkstation);
  $totalRows_allworkstation = mysql_num_rows($all_allworkstation);
}
$totalPages_allworkstation = ceil($totalRows_allworkstation/$maxRows_allworkstation)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>Add Worksattion</title>
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
    <a class="navbar-brand" href="#">Username</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
       

        <li class="nav-item">
          <a class="nav-link" href="dashboardadmin.php">Dashboard</a>
        </li>


        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            Crimes/Case
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="crimes.php">Crimes</a></li>
            <li><a class="dropdown-item" href="victims.php">Victims</a></li>
            <li><a class="dropdown-item" href="suspects.php">Suspects</a></li>
            <li><a class="dropdown-item" href="witness.php">Witness</a></li>
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

<br><br>

  
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="workstation" value="" placeholder="Workstation Name" class="myinputtext"/></td>
    </tr>
    <tr valign="baseline">
      <td><textarea  name="description" placeholder="workstation description" class="myinputtext">
      	
      </textarea></td>
    </tr>
    <tr valign="baseline">
      <td><input type="date" name="dateadded" value="" class="myinputtext" /></td>
    </tr>
   
    <tr valign="baseline">
      <td>
      <select  name="departmentID" class="myoption">
        <?php
do {  
?>
        <option value="<?php echo $row_comdepartments['departmentId']?>"<?php if (!(strcmp($row_comdepartments['departmentId'], $row_comdepartments['departmentId']))) {echo "selected=\"selected\"";} ?>><?php echo $row_comdepartments['departmentName']?></option>
        <?php
} while ($row_comdepartments = mysql_fetch_assoc($comdepartments));
  $rows = mysql_num_rows($comdepartments);
  if($rows > 0) {
      mysql_data_seek($comdepartments, 0);
	  $row_comdepartments = mysql_fetch_assoc($comdepartments);
  }
?>
      </select>
      
      </td>
    </tr>
    
    <tr valign="baseline">
      <td><input type="submit" value="Insert record" class="mybutton"/></td>
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
    <th>ID</th>
    <th>Department</th>
    <th>Work Station</th>
    <th>Description</th>
    <th>Date added</th>
    <th>Last updated</th>
    <th>Status</th>
    
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_allworkstation['workstationID']; ?></td>
      <td><?php echo $row_allworkstation['departmentName']; ?></td>
      <td><?php echo $row_allworkstation['workstation']; ?></td>
      <td><?php echo $row_allworkstation['description']; ?></td>
      <td><?php echo $row_allworkstation['dateadded']; ?></td>
      <td><?php echo $row_allworkstation['dateupdated']; ?></td>
      <td><?php  if ($row_allworkstation['status'] == 1) {
        // code...
        echo "Active";
      }else{
        echo "Not Active";
      }

       ?></td>
    </tr>
    <?php } while ($row_allworkstation = mysql_fetch_assoc($allworkstation)); ?>
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
mysql_free_result($comdepartments);

mysql_free_result($allworkstation);
?>
