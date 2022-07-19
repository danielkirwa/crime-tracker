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
  $insertSQL = sprintf("INSERT INTO tblvictim (firstname, othername, gender, idnumber, phone, `description`, countyid, constituencyid, wardid, dateadded, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['othername'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['idnumber'], "int"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['countyid'], "int"),
                       GetSQLValueString($_POST['constituencyid'], "int"),
                       GetSQLValueString($_POST['wardid'], "int"),
                       GetSQLValueString($_POST['dateadded'], "date"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

mysql_select_db($database_crimecon, $crimecon);
$query_cmbward = "SELECT tblward.wardID, tblward.wardname FROM tblward WHERE tblward.status = 1";
$cmbward = mysql_query($query_cmbward, $crimecon) or die(mysql_error());
$row_cmbward = mysql_fetch_assoc($cmbward);
$totalRows_cmbward = mysql_num_rows($cmbward);

mysql_select_db($database_crimecon, $crimecon);
$query_cmbcounty = "SELECT tblcounty.countyID, tblcounty.countyname FROM tblcounty WHERE tblcounty.status =1";
$cmbcounty = mysql_query($query_cmbcounty, $crimecon) or die(mysql_error());
$row_cmbcounty = mysql_fetch_assoc($cmbcounty);
$totalRows_cmbcounty = mysql_num_rows($cmbcounty);

mysql_select_db($database_crimecon, $crimecon);
$query_cmbconstituency = "SELECT tblconstituency.constituencyID, tblconstituency.constituencyname FROM tblconstituency WHERE tblconstituency.status = 1";
$cmbconstituency = mysql_query($query_cmbconstituency, $crimecon) or die(mysql_error());
$row_cmbconstituency = mysql_fetch_assoc($cmbconstituency);
$totalRows_cmbconstituency = mysql_num_rows($cmbconstituency);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Victim</title>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="firstname" value="" size="32" placeholder="First name" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="othername" value="" size="32" placeholder="Other name" /></td>
    </tr>
    <tr valign="baseline">
      <td>
        <select name="gender">
          <option>Select Gender</option>
          <option>MALE</option>
          <option>FEMALE</option>
        </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="idnumber" value="" size="32" placeholder="ID number" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="phone" value="" size="32" placeholder="Phone number" /></td>
    </tr>
    <tr valign="baseline">
      <td>
        <textarea name="description" placeholder="Victim Description">
          
        </textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <select name="countyid">
          <option value="0" <?php if (!(strcmp(0, $row_cmbcounty['countyID']))) {echo "selected=\"selected\"";} ?>>Select County</option>
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
      <td>
        <select name="constituencyid">
          <option value="0" <?php if (!(strcmp(0, $row_cmbconstituency['constituencyID']))) {echo "selected=\"selected\"";} ?>>Select Constituency</option>
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
      <td>
        <select name="wardid">
          <option value="0" <?php if (!(strcmp(0, $row_cmbward['wardID']))) {echo "selected=\"selected\"";} ?>>Select Ward</option>
          <?php
do {  
?>
          <option value="<?php echo $row_cmbward['wardID']?>"<?php if (!(strcmp($row_cmbward['wardID'], $row_cmbward['wardID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_cmbward['wardname']?></option>
          <?php
} while ($row_cmbward = mysql_fetch_assoc($cmbward));
  $rows = mysql_num_rows($cmbward);
  if($rows > 0) {
      mysql_data_seek($cmbward, 0);
	  $row_cmbward = mysql_fetch_assoc($cmbward);
  }
?>
        </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="date" name="dateadded" value="" size="32" /></td>
    </tr>
  
    <tr valign="baseline">

      <td><input type="submit" value="Submit Victim" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($cmbward);

mysql_free_result($cmbcounty);

mysql_free_result($cmbconstituency);
?>
