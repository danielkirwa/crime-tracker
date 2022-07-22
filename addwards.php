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
  $insertSQL = sprintf("INSERT INTO tblward (wardname, `description`, dateadded, dateupdated, constituemcyID, status) VALUES (%s, %s, %s, %s, %s , 1)",
                       GetSQLValueString($_POST['wardname'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['constituemcyID'], "int"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}



mysql_select_db($database_crimecon, $crimecon);
$query_cmbconstituency = "SELECT tblconstituency.constituencyID, tblconstituency.constituencyname FROM tblconstituency WHERE tblconstituency.status =1";
$cmbconstituency = mysql_query($query_cmbconstituency, $crimecon) or die(mysql_error());
$row_cmbconstituency = mysql_fetch_assoc($cmbconstituency);
$totalRows_cmbconstituency = mysql_num_rows($cmbconstituency);

$maxRows_allwards = 10;
$pageNum_allwards = 0;
if (isset($_GET['pageNum_allwards'])) {
  $pageNum_allwards = $_GET['pageNum_allwards'];
}
$startRow_allwards = $pageNum_allwards * $maxRows_allwards;

mysql_select_db($database_crimecon, $crimecon);
$query_allwards = "SELECT tblward.wardID, tblward.wardname, tblward.`description`, tblward.dateadded, tblward.dateupdated, tblward.status, tblward.constituemcyID, tblconstituency.constituencyname FROM tblward, tblconstituency WHERE tblconstituency.constituencyID = tblward.constituemcyID";
$query_limit_allwards = sprintf("%s LIMIT %d, %d", $query_allwards, $startRow_allwards, $maxRows_allwards);
$allwards = mysql_query($query_limit_allwards, $crimecon) or die(mysql_error());
$row_allwards = mysql_fetch_assoc($allwards);

if (isset($_GET['totalRows_allwards'])) {
  $totalRows_allwards = $_GET['totalRows_allwards'];
} else {
  $all_allwards = mysql_query($query_allwards);
  $totalRows_allwards = mysql_num_rows($all_allwards);
}
$totalPages_allwards = ceil($totalRows_allwards/$maxRows_allwards)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>Add Wards</title>
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
      <td><input type="text" name="wardname" value="" size="32" placeholder="Ward name" /></td>
    </tr>
    <tr valign="baseline">
      <td>
        <textarea name="description" placeholder="Ward description">
          
        </textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="date" name="dateadded" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td>
         <select name="constituemcyID">
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
    <th>Ward name</th>
    <th>Constituency</th>
    <th>Description</th>
    <th>Date added</th>
    <th>Last updated</th>
    <th>Status</th>
    
  </tr>
  </thead>
  <tbody>
    
 <?php do { ?>
    <tr>
      <td><?php echo $row_allwards['wardID']; ?></td>
      <td><?php echo $row_allwards['wardname']; ?></td>
      <td><?php echo $row_allwards['constituencyname']; ?></td>
      <td><?php echo $row_allwards['description']; ?></td>
      <td><?php echo $row_allwards['dateadded']; ?></td>
      <td><?php echo $row_allwards['dateupdated']; ?></td>
      <td><?php  if ($row_allwards['status'] == 1) {
        // code...
        echo "Active";
      }else{
        echo "Not Active";
      }
         ?></td>
    </tr>
    <?php } while ($row_allwards = mysql_fetch_assoc($allwards)); ?>
    </tbody>
</table>
  </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
<?php


mysql_free_result($cmbconstituency);

mysql_free_result($allwards);
?>
