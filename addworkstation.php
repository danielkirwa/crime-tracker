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
<title>Add Worksattion</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="workstation" value="" size="32" placeholder="Workstation Name" /></td>
    </tr>
    <tr valign="baseline">
      <td><textarea  name="description" placeholder="workstation description">
      	
      </textarea></td>
    </tr>
    <tr valign="baseline">
      <td><input type="date" name="dateadded" value="" size="32" /></td>
    </tr>
   
    <tr valign="baseline">
      <td>
      <select  name="departmentID">
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
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>ID</td>
    <td>Department</td>
    <td>Work Station</td>
    <td>Description</td>
    <td>Date added</td>
    <td>Last updated</td>
    <td>Status</td>
  </tr>
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
</table>
</body>
</html>
<?php
mysql_free_result($comdepartments);

mysql_free_result($allworkstation);
?>
