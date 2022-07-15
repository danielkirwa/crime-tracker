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
  $insertSQL = sprintf("INSERT INTO tblconstituency ( constituencyname, `description`, dateadded, dateupdated, countyID, status) VALUES (%s, %s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['constituencyname'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['countyID'], "int"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

mysql_select_db($database_crimecon, $crimecon);
$query_cmbcounty = "SELECT tblcounty.countyID, tblcounty.countyname FROM tblcounty";
$cmbcounty = mysql_query($query_cmbcounty, $crimecon) or die(mysql_error());
$row_cmbcounty = mysql_fetch_assoc($cmbcounty);
$totalRows_cmbcounty = mysql_num_rows($cmbcounty);

$maxRows_allconstituency = 10;
$pageNum_allconstituency = 0;
if (isset($_GET['pageNum_allconstituency'])) {
  $pageNum_allconstituency = $_GET['pageNum_allconstituency'];
}
$startRow_allconstituency = $pageNum_allconstituency * $maxRows_allconstituency;

mysql_select_db($database_crimecon, $crimecon);
$query_allconstituency = "SELECT tblconstituency.constituencyID, tblconstituency.constituencyname, tblconstituency.`description`, tblconstituency.dateadded, tblconstituency.dateupdated, tblconstituency.status, tblcounty.countyname FROM tblconstituency, tblcounty WHERE tblcounty.countyID = tblconstituency.countyID";
$query_limit_allconstituency = sprintf("%s LIMIT %d, %d", $query_allconstituency, $startRow_allconstituency, $maxRows_allconstituency);
$allconstituency = mysql_query($query_limit_allconstituency, $crimecon) or die(mysql_error());
$row_allconstituency = mysql_fetch_assoc($allconstituency);

if (isset($_GET['totalRows_allconstituency'])) {
  $totalRows_allconstituency = $_GET['totalRows_allconstituency'];
} else {
  $all_allconstituency = mysql_query($query_allconstituency);
  $totalRows_allconstituency = mysql_num_rows($all_allconstituency);
}
$totalPages_allconstituency = ceil($totalRows_allconstituency/$maxRows_allconstituency)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Constituency</title>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="constituencyname" value="" size="32" placeholder="Constituency name" /></td>
    </tr>
    <tr valign="baseline">

      <td>
     <textarea name="description" placeholder="Description">
     	

     </textarea>
      </td>
    </tr>
    <tr valign="baseline">
     
      <td><input type="date" name="dateadded" value="" size="32" /></td>
    </tr>
    
    <tr valign="baseline">

      <td>
        <select name="countyID">
          <?php
do {  
?>
          <option value="<?php echo $row_cmbcounty['countyID']?>"<?php if (!(strcmp($row_cmbcounty['countyID'], $row_cmbcounty['countyID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_cmbcounty['countyname']?></option>
          <?php
} while ($row_cmbcounty = mysql_fetch_assoc($cmbcounty));
  $rows = mysql_num_rows($cmbcounty);
  if($rows > 0) {
      mysql_data_seek($cmbcounty, 0);
	  $row_cmbcounty = mysql_fetch_assoc($cmbcounty);
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
    <td>County</td>
    <td>Constituency</td>
    <td>Description</td>
    <td>Date added</td>
    <td>Last updated</td>
    <td>Status</td>
    
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_allconstituency['constituencyID']; ?></td>
      <td><?php echo $row_allconstituency['countyname']; ?></td>
      <td><?php echo $row_allconstituency['constituencyname']; ?></td>
      <td><?php echo $row_allconstituency['description']; ?></td>
      <td><?php echo $row_allconstituency['dateadded']; ?></td>
      <td><?php echo $row_allconstituency['dateupdated']; ?></td>
      <td><?php if ($row_allconstituency['status'] == 1) {
      	// code...
      	echo "Active";
      }else{
      	echo "Not Active";
      } ?></td>
      
    </tr>
    <?php } while ($row_allconstituency = mysql_fetch_assoc($allconstituency)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($cmbcounty);

mysql_free_result($allconstituency);
?>
