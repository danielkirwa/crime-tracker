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
  $insertSQL = sprintf("INSERT INTO tblward (wardname, `description`, dateadded, dateupdated, status, constituemcyID) VALUES (%s, %s, %s, %s, %s , 1)",
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
<title>Add Wards</title>
</head>
<body>
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
<table border="1">
  <tr>
    <td>ID</td>
    <td>Ward name</td>
    <td>Constituency</td>
    <td>Description</td>
    <td>Date added</td>
    <td>Last updated</td>
    <td>Status</td>
  </tr>
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
</table>
</body>
</html>
<?php


mysql_free_result($cmbconstituency);

mysql_free_result($allwards);
?>
