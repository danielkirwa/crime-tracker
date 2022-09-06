<?php require_once('Connections/crimecon.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

if ($_SESSION['username']) {
  // code...
 $currentUser =   $_SESSION['username'];
}else{
    header("Location:login.php");
}

?>
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
  $insertSQL = sprintf("INSERT INTO tbladvice (title, advice,dateadded, status) VALUES (%s, %s, %s,1)",
                       GetSQLValueString($_POST['Title'], "text"),
                       GetSQLValueString($_POST['advice'], "text"),
                       GetSQLValueString($_POST['dateadded'], "date"));

  mysql_select_db($database_crimecon, $crimecon);
  $Result1 = mysql_query($insertSQL, $crimecon) or die(mysql_error());
}

$maxRows_ActiveAdvice = 10;
$pageNum_ActiveAdvice = 0;
if (isset($_GET['pageNum_ActiveAdvice'])) {
  $pageNum_ActiveAdvice = $_GET['pageNum_ActiveAdvice'];
}
$startRow_ActiveAdvice = $pageNum_ActiveAdvice * $maxRows_ActiveAdvice;

mysql_select_db($database_crimecon, $crimecon);
$query_ActiveAdvice = "SELECT tbladvice.adviceID, tbladvice.title, tbladvice.advice, tbladvice.dateadded FROM tbladvice  WHERE tbladvice.status = 1";
$query_limit_ActiveAdvice = sprintf("%s LIMIT %d, %d", $query_ActiveAdvice, $startRow_ActiveAdvice, $maxRows_ActiveAdvice);
$ActiveAdvice = mysql_query($query_limit_ActiveAdvice, $crimecon) or die(mysql_error());
$row_ActiveAdvice = mysql_fetch_assoc($ActiveAdvice);

if (isset($_GET['totalRows_ActiveAdvice'])) {
  $totalRows_ActiveAdvice = $_GET['totalRows_ActiveAdvice'];
} else {
  $all_ActiveAdvice = mysql_query($query_ActiveAdvice);
  $totalRows_ActiveAdvice = mysql_num_rows($all_ActiveAdvice);
}
$totalPages_ActiveAdvice = ceil($totalRows_ActiveAdvice/$maxRows_ActiveAdvice)-1;

$maxRows_ClosedAdvice = 10;
$pageNum_ClosedAdvice = 0;
if (isset($_GET['pageNum_ClosedAdvice'])) {
  $pageNum_ClosedAdvice = $_GET['pageNum_ClosedAdvice'];
}
$startRow_ClosedAdvice = $pageNum_ClosedAdvice * $maxRows_ClosedAdvice;

mysql_select_db($database_crimecon, $crimecon);
$query_ClosedAdvice = "SELECT tbladvice.adviceID, tbladvice.title, tbladvice.advice, tbladvice.dateadded FROM tbladvice WHERE tbladvice.status = 0";
$query_limit_ClosedAdvice = sprintf("%s LIMIT %d, %d", $query_ClosedAdvice, $startRow_ClosedAdvice, $maxRows_ClosedAdvice);
$ClosedAdvice = mysql_query($query_limit_ClosedAdvice, $crimecon) or die(mysql_error());
$row_ClosedAdvice = mysql_fetch_assoc($ClosedAdvice);

if (isset($_GET['totalRows_ClosedAdvice'])) {
  $totalRows_ClosedAdvice = $_GET['totalRows_ClosedAdvice'];
} else {
  $all_ClosedAdvice = mysql_query($query_ClosedAdvice);
  $totalRows_ClosedAdvice = mysql_num_rows($all_ClosedAdvice);
}
$totalPages_ClosedAdvice = ceil($totalRows_ClosedAdvice/$maxRows_ClosedAdvice)-1;
?>

<?php 

   if(isset($_POST['btncloseadvice'])){
    $closeid = $_POST['btncloseadvice'];
  
   $close_advice = "UPDATE tbladvice SET status = 0 WHERE adviceID = '$closeid' ";
   if (mysql_query($close_advice)) {
     // code...
    echo '<script>alert ("Advice Closed successfuly")</script>';
    header("Location:advice.php");
   }else{
      echo '<script>alert ("Failed to Close Advice")</script>';
   }

   mysql_query($close_advice) or die(mysql_error());

}
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>Advice</title>
</head>
<body>

<nav class="shadow-lg p-3 mb-5 bg-body rounded">
   <div class="logoholder">
    <div class="logo-holder">
      <img src="assets/logo/logo.png">
    </div>
    <div class="name-holder">
      <h3>Bungoma county crime logger</h3>
    </div>
   </div>
   </nav>
   <hr>
      
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="#">Username</a> -->

      <li class="nav-item dropdown">
          <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['username'] ?> </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="adminusermanual.php">User Guide </a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="dashboardadmin.php">Dashboard</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Crimes/Case
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="crimes.php">Crimes</a></li>
            <li><a class="dropdown-item" href="victims.php">Victims</a></li>
            <li><a class="dropdown-item" href="suspects.php">Suspects</a></li>
            <li><a class="dropdown-item" href="witness.php">Witness</a></li>
            <li><a class="dropdown-item" href="addcrimesection.php">Add Section</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Officers
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="officerregistration.php">Add Officer</a></li>
            <li><a class="dropdown-item" href="adddepartment.php">Add Department</a></li>
            <li><a class="dropdown-item" href="addworkstation.php">Add WorkStation</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Location
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="addcounty.php">Add County</a></li>
            <li><a class="dropdown-item" href="addconstituency.php">Add Constituency</a></li>
            <li><a class="dropdown-item" href="addwards.php">Add Wards</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="systemusers.php">All Users</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>



<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><input type="text" name="Title" value="" placeholder="Title" class="myinputtext" /></td>
    </tr>
    <tr valign="baseline">
      <td><textarea name="advice" placeholder="Advice note" class="myinputtext">
          </textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="date" name="dateadded" value="" class="myinputtext" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="submit" value="Save advice" class="mybutton" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>

<br><br>

<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">Open Advice <span></span></label>
    </div>
    <table>
      <thead>
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Advice</th>
    <th>Date Added</th>
    
  </tr>
  </thead>
  <tbody>
 <?php do { ?>
    <tr>
      <td><?php echo $row_ActiveAdvice['adviceID']; ?></td>
      <td><?php echo $row_ActiveAdvice['title']; ?></td>
      <td><?php echo $row_ActiveAdvice['advice']; ?></td>
      <td><?php echo $row_ActiveAdvice['dateadded']; ?></td>
      <td><form action="advice.php" method="POST" name="formcloseadvice" id="closeadvice1"> <button class="myActionbutton" value="<?php echo $row_ActiveAdvice['adviceID']; ?>" name="btncloseadvice">Close</button>
      </form>
    </td>
    </tr>
    <?php } while ($row_ActiveAdvice = mysql_fetch_assoc($ActiveAdvice)); ?>
    </tbody>
</table>
  </div>
  </div>



<div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">All Closed Advice <span></span></label>
    </div>
    <table>
      <thead>
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Advice</th>
    <th>Date Added</th>
    
  </tr>
  </thead>
  <tbody>
 <?php do { ?>
    <tr>
      <td><?php echo $row_ClosedAdvice['adviceID']; ?></td>
      <td><?php echo $row_ClosedAdvice['title']; ?></td>
      <td><?php echo $row_ClosedAdvice['advice']; ?></td>
      <td><?php echo $row_ClosedAdvice['dateadded']; ?></td>
    </tr>
    <?php } while ($row_ClosedAdvice = mysql_fetch_assoc($ClosedAdvice)); ?>
    </tbody>
</table>
  </div>
  </div>



<div class="footer-dark">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Services</h3>
                        <ul>
                            <li><a href="#">Crime reporting</a></li>
                            <li><a href="#">Crime alerts</a></li>
                            <li><a href="#">Danger Zone </a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>About</h3>
                        <ul>
                            <li><a href="#">Police</a></li>
                            <li><a href="#">CID</a></li>
                            <li><a href="#">DCI</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 item text">
                        <h3>Bungoma  Crime Logger</h3>
                        <p>This is bungoma county crime reporting system that aid in capturing crime details reported by residence to tha law enforcers.</p>
                    </div>
                    
                </div>
                <p class="copyright">Bungoma  Crime Logger &copy; 2022</p>
            </div>
        </footer>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysql_free_result($ActiveAdvice);

mysql_free_result($ClosedAdvice);
?>
