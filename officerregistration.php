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
  $insertSQL = sprintf("INSERT INTO tblofficers (firstname, othername, phone, email, gender, officernumber, departmentID, workstationID, dateadded, dateupdated, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 1)",
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['othername'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['officernumber'], "int"),
                       GetSQLValueString($_POST['departmentID'], "int"),
                       GetSQLValueString($_POST['workstationID'], "int"),
                       GetSQLValueString($_POST['dateadded'], "date"),
                       GetSQLValueString($_POST['dateadded'], "date"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

mysql_select_db($database_crimecon, $crimecon);
$query_alldepartmentofficer = "SELECT tbldepartment.departmentId, tbldepartment.departmentName FROM tbldepartment WHERE tbldepartment.status =1";
$alldepartmentofficer = mysql_query($query_alldepartmentofficer, $crimecon) or die(mysql_error());
$row_alldepartmentofficer = mysql_fetch_assoc($alldepartmentofficer);
$totalRows_alldepartmentofficer = mysql_num_rows($alldepartmentofficer);

mysql_select_db($database_crimecon, $crimecon);
$query_allworkstationcode = "SELECT tblworkstation.workstationID, tblworkstation.workstation FROM tblworkstation WHERE tblworkstation.status =1  ";
$allworkstationcode = mysql_query($query_allworkstationcode, $crimecon) or die(mysql_error());
$row_allworkstationcode = mysql_fetch_assoc($allworkstationcode);
$totalRows_allworkstationcode = mysql_num_rows($allworkstationcode);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>Officer Registration</title>
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
      <td><input type="text" name="phone" value="" size="32" placeholder="071234..." /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="email" value="" size="32" placeholder="Enter email" /></td>
    </tr>
    <tr valign="baseline">
      <td>
         <select  name="gender">
         	<option>Select Gender</option>
         	<option>MALE</option>
         	<option>FEMALE</option>
         </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="text" name="officernumber" value="" size="32" placeholder="Enter Id number" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DepartmentID:</td>
      <td>
        <select  name="departmentID">
          <?php
do {  
?>
          <option value="<?php echo $row_alldepartmentofficer['departmentId']?>"<?php if (!(strcmp($row_alldepartmentofficer['departmentId'], $row_alldepartmentofficer['departmentId']))) {echo "selected=\"selected\"";} ?>><?php echo $row_alldepartmentofficer['departmentName']?></option>
          <?php
} while ($row_alldepartmentofficer = mysql_fetch_assoc($alldepartmentofficer));
  $rows = mysql_num_rows($alldepartmentofficer);
  if($rows > 0) {
      mysql_data_seek($alldepartmentofficer, 0);
	  $row_alldepartmentofficer = mysql_fetch_assoc($alldepartmentofficer);
  }
?>
        </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">WorkstationID:</td>
      <td>
      
      <select name="workstationID">
        <?php
do {  
?>
        <option value="<?php echo $row_allworkstationcode['workstationID']?>"<?php if (!(strcmp($row_allworkstationcode['workstationID'], $row_allworkstationcode['workstationID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_allworkstationcode['workstation']?></option>
        <?php
} while ($row_allworkstationcode = mysql_fetch_assoc($allworkstationcode));
  $rows = mysql_num_rows($allworkstationcode);
  if($rows > 0) {
      mysql_data_seek($allworkstationcode, 0);
	  $row_allworkstationcode = mysql_fetch_assoc($allworkstationcode);
  }
?>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Dateadded:</td>
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

</body>
</html>
<?php
mysql_free_result($alldepartmentofficer);

mysql_free_result($allworkstationcode);
?>
