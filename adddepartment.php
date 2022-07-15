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
  $insertSQL = sprintf("INSERT INTO tbldepartment (departmentName, `description`, dateadded, dateupdated, status) VALUES ( %s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['departmentName'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['dateadded'], "date"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

$maxRows_alldepartments = 10;
$pageNum_alldepartments = 0;
if (isset($_GET['pageNum_alldepartments'])) {
  $pageNum_alldepartments = $_GET['pageNum_alldepartments'];
}
$startRow_alldepartments = $pageNum_alldepartments * $maxRows_alldepartments;

mysql_select_db($database_crimecon, $crimecon);
$query_alldepartments = "SELECT * FROM tbldepartment";
$query_limit_alldepartments = sprintf("%s LIMIT %d, %d", $query_alldepartments, $startRow_alldepartments, $maxRows_alldepartments);
$alldepartments = mysql_query($query_limit_alldepartments, $crimecon) or die(mysql_error());
$row_alldepartments = mysql_fetch_assoc($alldepartments);

if (isset($_GET['totalRows_alldepartments'])) {
  $totalRows_alldepartments = $_GET['totalRows_alldepartments'];
} else {
  $all_alldepartments = mysql_query($query_alldepartments);
  $totalRows_alldepartments = mysql_num_rows($all_alldepartments);
}
$totalPages_alldepartments = ceil($totalRows_alldepartments/$maxRows_alldepartments)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Departments</title>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="departmentName" value="" size="32" placeholder="Department Name" /></td>
    </tr>
    <tr valign="baseline">
      <td><textarea name="description" placeholder="Department Description"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td><input type="date" name="dateadded" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Add Department" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Description</td>
    <td>Date added</td>
    <td>Last updated</td>
    <td>Status</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_alldepartments['departmentId']; ?></td>
      <td><?php echo $row_alldepartments['departmentName']; ?></td>
      <td><?php echo $row_alldepartments['description']; ?></td>
      <td><?php echo $row_alldepartments['dateadded']; ?></td>
      <td><?php echo $row_alldepartments['dateupdated']; ?></td>
      <td><?php  if ($row_alldepartments['status'] == 1) {
        // code...
        echo "Active";
      } else{
        echo "Not Active";
      } ?></td>
    </tr>
    <?php } while ($row_alldepartments = mysql_fetch_assoc($alldepartments)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($alldepartments);
?>
