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
  $insertSQL = sprintf("INSERT INTO tblcounty (countyname, `description`, dateadded, dateupdated, status) VALUES (%s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['countyname'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['dateadded'], "date"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

$maxRows_allcounty = 10;
$pageNum_allcounty = 0;
if (isset($_GET['pageNum_allcounty'])) {
  $pageNum_allcounty = $_GET['pageNum_allcounty'];
}
$startRow_allcounty = $pageNum_allcounty * $maxRows_allcounty;

mysql_select_db($database_crimecon, $crimecon);
$query_allcounty = "SELECT * FROM tblcounty";
$query_limit_allcounty = sprintf("%s LIMIT %d, %d", $query_allcounty, $startRow_allcounty, $maxRows_allcounty);
$allcounty = mysql_query($query_limit_allcounty, $crimecon) or die(mysql_error());
$row_allcounty = mysql_fetch_assoc($allcounty);

if (isset($_GET['totalRows_allcounty'])) {
  $totalRows_allcounty = $_GET['totalRows_allcounty'];
} else {
  $all_allcounty = mysql_query($query_allcounty);
  $totalRows_allcounty = mysql_num_rows($all_allcounty);
}
$totalPages_allcounty = ceil($totalRows_allcounty/$maxRows_allcounty)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Counties</title>
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle  active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Location
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="addcounty.php">Add County</a></li>
            <li><a class="dropdown-item" href="addconstituency.php">Add Constituency</a></li>
            <li><a class="dropdown-item" href="addwards.php">Add Wards</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="dashboardadmin.php">Dashboard</a>
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
            <li><a class="dropdown-item" href="#addconstituency.php">Add Constituency</a></li>
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
      <td><input type="text" name="countyname" value="" size="32" placeholder="County name" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="description" value="" size="32" placeholder="Description" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="date" name="dateadded" value="" size="32" /></td>
    </tr>
  
   
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
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
    <th>County</th>
    <th>Description</th>
    <th>Date added</th>
    <th>Last updated</th>
    <th>Status</th>
    
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_allcounty['countyID']; ?></td>
      <td><?php echo $row_allcounty['countyname']; ?></td>
      <td><?php echo $row_allcounty['description']; ?></td>
      <td><?php echo $row_allcounty['dateadded']; ?></td>
      <td><?php echo $row_allcounty['dateupdated']; ?></td>
      <td><?php if ($row_allcounty['status'] == 1) {
        // code... 
        echo "Active";
      }else{
        echo "Not Active";
      } ?></td>
    </tr>
    <?php } while ($row_allcounty = mysql_fetch_assoc($allcounty)); ?>
    </tbody>
</table>
  </div>
  </div>








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysql_free_result($allcounty);
?>
