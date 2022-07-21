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
  $insertSQL = sprintf("INSERT INTO tblsection (sectionnmae, `description`, dateadded, dateupdated, status) VALUES ( %s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['sectionnmae'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['dateadded'], "date"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

$maxRows_allsections = 10;
$pageNum_allsections = 0;
if (isset($_GET['pageNum_allsections'])) {
  $pageNum_allsections = $_GET['pageNum_allsections'];
}
$startRow_allsections = $pageNum_allsections * $maxRows_allsections;

mysql_select_db($database_crimecon, $crimecon);
$query_allsections = "SELECT * FROM tblsection";
$query_limit_allsections = sprintf("%s LIMIT %d, %d", $query_allsections, $startRow_allsections, $maxRows_allsections);
$allsections = mysql_query($query_limit_allsections, $crimecon) or die(mysql_error());
$row_allsections = mysql_fetch_assoc($allsections);

if (isset($_GET['totalRows_allsections'])) {
  $totalRows_allsections = $_GET['totalRows_allsections'];
} else {
  $all_allsections = mysql_query($query_allsections);
  $totalRows_allsections = mysql_num_rows($all_allsections);
}
$totalPages_allsections = ceil($totalRows_allsections/$maxRows_allsections)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<title>Crime section</title>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="sectionnmae" value="" size="32" placeholder="Section Name" /></td>
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
      <label class="largeText dodgerblueText">Availlable Sections <span></span></label>
    </div>
    <table>
      <thead>
  <tr>
    <th>ID</th>
    <th>Section Name</th>
    <th>Description</th>
    <th>Date added</th>
    <th>Last updated</th>
    <th>Status</th>
    
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_allsections['sectionID']; ?></td>
      <td><?php echo $row_allsections['sectionnmae']; ?></td>
      <td><?php echo $row_allsections['description']; ?></td>
      <td><?php echo $row_allsections['dateadded']; ?></td>
      <td><?php echo $row_allsections['dateupdated']; ?></td>
      <td><?php if ($row_allsections['status'] == 1) {
        // code...
        echo "Active";
      }else{
        echo "Not Active";
      } ?></td>
    </tr>
    <?php } while ($row_allsections = mysql_fetch_assoc($allsections)); ?>
    </tbody>
</table>
  </div>
  </div>


</body>
</html>
<?php
mysql_free_result($allsections);
?>
