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

mysql_select_db($database_crimecon, $crimecon);
$query_adminAllcrimes = "SELECT tblcrime.crimeID FROM tblcrime";
$adminAllcrimes = mysql_query($query_adminAllcrimes, $crimecon) or die(mysql_error());
$row_adminAllcrimes = mysql_fetch_assoc($adminAllcrimes);
$totalRows_adminAllcrimes = mysql_num_rows($adminAllcrimes);

mysql_select_db($database_crimecon, $crimecon);
$query_userprofile = "SELECT tblresidence.residenceID, tblresidence.residenceIdNumber, tblresidence.firstname, tblresidence.othername, tblresidence.gender, tblresidence.phone, tblresidence.email, tblresidence.village, tblresidence.status, tblward.wardname, tblconstituency.constituencyname, tblcounty.countyname FROM tblresidence, tblward, tblconstituency, tblcounty WHERE tblward.wardID = tblresidence.wardID AND tblconstituency.constituencyID = tblresidence.consituencyID AND tblcounty.countyID =  tblresidence.countyID AND tblresidence.email = 1 ";
$userprofile = mysql_query($query_userprofile, $crimecon) or die(mysql_error());
$row_userprofile = mysql_fetch_assoc($userprofile);
$totalRows_userprofile = mysql_num_rows($userprofile);

mysql_select_db($database_crimecon, $crimecon);
$query_userid = "SELECT tblresidence.residenceID, tblresidence.email FROM tblresidence WHERE tblresidence.email = 1";
$userid = mysql_query($query_userid, $crimecon) or die(mysql_error());
$row_userid = mysql_fetch_assoc($userid);
$totalRows_userid = mysql_num_rows($userid);

mysql_select_db($database_crimecon, $crimecon);
$query_mylogedcrime = "SELECT tblcrime.crimeID, tblcrime.sectionID, tblcrime.dateadded, tblcrime.status, tblsuspectcrime.crimeID, tblsuspectcrime.suspectID, tblsuspect.suspectID, tblvictim.victimID, tblvictimcrime.victimID, tblvictimcrime.crimeID, tblwitness.witnessID, tblwitnesscrime.crimeID, tblwitnesscrime.witnessID FROM tblcrime, tblsuspectcrime, tblsuspect, tblvictim, tblvictimcrime, tblwitness, tblwitnesscrime WHERE tblsuspectcrime.crimeID = tblcrime.crimeID  AND tblsuspect.suspectID =  tblsuspectcrime.suspectID   AND tblvictimcrime.crimeID = tblcrime.crimeID   AND tblvictim.victimID =  tblvictimcrime.victimID  AND tblwitnesscrime.crimeID = tblcrime.crimeID  AND tblwitness.witnessID = tblwitnesscrime.witnessID";
$mylogedcrime = mysql_query($query_mylogedcrime, $crimecon) or die(mysql_error());
$row_mylogedcrime = mysql_fetch_assoc($mylogedcrime);
$totalRows_mylogedcrime = mysql_num_rows($mylogedcrime);

mysql_select_db($database_crimecon, $crimecon);
$query_userlogedcrime = "SELECT tblcrime.crimeID, tblcrime.sectionID, tblcrime.dateadded, tblcrime.status, tblsuspect.suspectID, tblvictim.victimID, tblwitness.witnessID FROM tblcrime, tblsuspectcrime, tblsuspect, tblvictim, tblvictimcrime, tblwitness, tblwitnesscrime WHERE tblsuspectcrime.crimeID = tblcrime.crimeID  AND tblsuspect.suspectID =  tblsuspectcrime.suspectID   AND tblvictimcrime.crimeID = tblcrime.crimeID   AND tblvictim.victimID =  tblvictimcrime.victimID  AND tblwitnesscrime.crimeID = tblcrime.crimeID  AND tblwitness.witnessID = tblwitnesscrime.witnessID";
$userlogedcrime = mysql_query($query_userlogedcrime, $crimecon) or die(mysql_error());
$row_userlogedcrime = mysql_fetch_assoc($userlogedcrime);
$totalRows_userlogedcrime = mysql_num_rows($userlogedcrime);

mysql_select_db($database_crimecon, $crimecon);
$query_userpostedcrime = "SELECT tblcrime.crimeID, tblcrime.sectionID, tblcrime.dateadded, tblcrime.status, tblsuspect.suspectID, tblvictim.victimID, tblwitness.witnessID FROM tblcrime, tblsuspectcrime, tblsuspect, tblvictim, tblvictimcrime, tblwitness, tblwitnesscrime, tblresidence WHERE tblsuspectcrime.crimeID = tblcrime.crimeID  AND tblsuspect.suspectID =  tblsuspectcrime.suspectID   AND tblvictimcrime.crimeID = tblcrime.crimeID   AND tblvictim.victimID =  tblvictimcrime.victimID  AND tblwitnesscrime.crimeID = tblcrime.crimeID  AND tblwitness.witnessID = tblwitnesscrime.witnessID AND tblcrime.complainerID = 1";
$userpostedcrime = mysql_query($query_userpostedcrime, $crimecon) or die(mysql_error());
$row_userpostedcrime = mysql_fetch_assoc($userpostedcrime);
$totalRows_userpostedcrime = mysql_num_rows($userpostedcrime);

mysql_select_db($database_crimecon, $crimecon);
$query_activeeditablecrime = "SELECT tblcrime.crimeID, tblcrime.dateadded, tblcrime.status, tblsection.sectionnmae FROM tblcrime, tblsection WHERE tblsection.sectionID =  tblcrime.sectionID  AND tblcrime.complainerID = 1";
$activeeditablecrime = mysql_query($query_activeeditablecrime, $crimecon) or die(mysql_error());
$row_activeeditablecrime = mysql_fetch_assoc($activeeditablecrime);
$totalRows_activeeditablecrime = mysql_num_rows($activeeditablecrime);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "privillage";
  $MM_redirectLoginSuccess = "userdashboard.php";
  $MM_redirectLoginFailed = "querytest.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_crimecon, $crimecon);
  	
  $LoginRS__query=sprintf("SELECT username, password, privillage FROM tblusers WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $crimecon) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'privillage');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test Queries</title>
</head>
<body>
<form action="<?php echo $loginFormAction; ?>" method="POST" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="username" value="" size="32" placeholder="Ward name" /></td>
    </tr>
   
    <tr valign="baseline">
      <td><input type="password" name="password" value="" size="32" /></td>
    </tr>
   
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Login" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($adminAllcrimes);

mysql_free_result($userprofile);

mysql_free_result($userid);

mysql_free_result($mylogedcrime);

mysql_free_result($userlogedcrime);

mysql_free_result($userpostedcrime);

mysql_free_result($activeeditablecrime);
?>




 /*Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}


$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "privillage";
  $MM_redirectLoginSuccess = "userdashboard.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_crimecon, $crimecon);
    
  $LoginRS__query=sprintf("SELECT username, password, privillage FROM tblusers WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $crimecon) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'privillage');
    
  if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;       

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];  
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}

