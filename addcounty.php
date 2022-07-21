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
</head>
<body>
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



</body>
</html>
<?php
mysql_free_result($allcounty);
?>
