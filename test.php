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
$searchCrime = 'Undefined';



mysql_select_db($database_crimecon, $crimecon);
$query_cmbconstituency = "SELECT tblconstituency.constituencyID, tblconstituency.constituencyname FROM tblconstituency WHERE tblconstituency.status = 1";
$cmbconstituency = mysql_query($query_cmbconstituency, $crimecon) or die(mysql_error());
$row_cmbconstituency = mysql_fetch_assoc($cmbconstituency);
$totalRows_cmbconstituency = mysql_num_rows($cmbconstituency);
?>
<?php 

   if(isset($_POST['btnsearch'])){
    $searchdate = $_POST['serachdateofoffence'];
    $searchplace = $_POST['searchconstituencyID'];

  $maxRows_searchCrime = 10;
$pageNum_searchCrime = 0;
if (isset($_GET['pageNum_searchCrime'])) {
  $pageNum_searchCrime = $_GET['pageNum_searchCrime'];
}
$startRow_searchCrime = $pageNum_searchCrime * $maxRows_searchCrime;

if($searchplace == 0){

mysql_select_db($database_crimecon, $crimecon);
$query_searchCrime = "SELECT tblcrime.crimeID,  tblcrime.description, tblcrime.dateofoffence, tblcrime.dateadded, tblcrime.status, tblsection.sectionnmae, tblresidence.firstname FROM tblcrime, tblsection, tblresidence WHERE tblsection.sectionID = tblcrime.sectionID  AND tblresidence.residenceID = tblcrime.complainerID AND tblcrime.dateadded = '$searchdate'";
$query_limit_searchCrime = sprintf("%s LIMIT %d, %d", $query_searchCrime, $startRow_searchCrime, $maxRows_searchCrime);
$searchCrime = mysql_query($query_limit_searchCrime, $crimecon) or die(mysql_error());
$row_searchCrime = mysql_fetch_assoc($searchCrime);
}else{
  mysql_select_db($database_crimecon, $crimecon);
$query_searchCrime = "SELECT tblcrime.crimeID,  tblcrime.description, tblcrime.dateofoffence, tblcrime.dateadded, tblcrime.status, tblsection.sectionnmae, tblresidence.firstname FROM tblcrime, tblsection, tblresidence WHERE tblsection.sectionID = tblcrime.sectionID  AND tblresidence.residenceID = tblcrime.complainerID AND tblcrime.dateadded = '$searchdate' AND tblcrime.constituencyID = '$searchplace'";
$query_limit_searchCrime = sprintf("%s LIMIT %d, %d", $query_searchCrime, $startRow_searchCrime, $maxRows_searchCrime);
$searchCrime = mysql_query($query_limit_searchCrime, $crimecon) or die(mysql_error());
$row_searchCrime = mysql_fetch_assoc($searchCrime);

}
if (isset($_GET['totalRows_searchCrime'])) {
  $totalRows_searchCrime = $_GET['totalRows_searchCrime'];
} else {
  $all_searchCrime = mysql_query($query_searchCrime);
  $totalRows_searchCrime = mysql_num_rows($all_searchCrime);
}
$totalPages_searchCrime = ceil($totalRows_searchCrime/$maxRows_searchCrime)-1;
echo $searchplace;


 }

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/admin.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body>

<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <form action="test.php" method="POST" name="searchcrime">
      <label class="largeText ">Date : </label><input type="date" name="serachdateofoffence" value="" class="myinputtextsmall" /> &nbsp;&nbsp;
      <label class="largeText ">Constituency : </label>&nbsp;&nbsp;
      <select name="searchconstituencyID" class="myoption">
        <option  value="0">
          Select Constituency
        </option>
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
      </select>&nbsp;&nbsp;
      <button class="myActionbutton" name="btnsearch">Search Crime</button>
    </form>
    </div>
    <table>
      <thead>
  <tr>
    <th>ID</th>
    <th>Section</th>
    <th>Description</th>
    <th>Date of offence</th>
    <th>Date Added</th>
    <th>Complainer</th>
    <th>Status</th>
    
  </tr>
  </thead>
  <tbody>
   </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_searchCrime['crimeID']; ?></td>
      <td><?php echo $row_searchCrime['sectionnmae']; ?></td>
      <td><?php echo $row_searchCrime['description']; ?></td>
      <td><?php echo $row_searchCrime['dateofoffence']; ?></td>
      <td><?php echo $row_searchCrime['dateadded']; ?></td>
      <td><?php echo $row_searchCrime['firstname']; ?></td>
      <td><?php echo $row_searchCrime['status']; ?></td>
      
      
    </tr>
    <?php } while ($row_searchCrime = mysql_fetch_assoc($searchCrime)); ?>
   
    </tbody>
</table>
  </div>
  </div>
</body>
</html>
<?php

if ($searchCrime ==  'Undefined') {
  // code...
}else{
  mysql_free_result($searchCrime);
}

mysql_free_result($cmbconstituency);
?>
