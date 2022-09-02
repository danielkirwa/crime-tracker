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

mysql_select_db($database_crimecon, $crimecon);
$query_mostcommoncrime = "SELECT  tblsection.sectionnmae, tblcrime.sectionID, tblsection.`description` FROM tblsection, tblcrime WHERE tblsection.sectionID = tblcrime.sectionID  ORDER BY tblsection.sectionID ASC LIMIT 1";
$mostcommoncrime = mysql_query($query_mostcommoncrime, $crimecon) or die(mysql_error());
$row_mostcommoncrime = mysql_fetch_assoc($mostcommoncrime);
$totalRows_mostcommoncrime = mysql_num_rows($mostcommoncrime);
mysql_select_db($database_crimecon, $crimecon);
$query_userid = "SELECT tblresidence.residenceID, tblresidence.email FROM tblresidence WHERE tblresidence.email = '{$currentUser}' ";
$userid = mysql_query($query_userid, $crimecon) or die(mysql_error());
$row_userid = mysql_fetch_assoc($userid);
$totalRows_userid = mysql_num_rows($userid);

$maxRows_userpostedcrime = 10;
$pageNum_userpostedcrime = 0;
if (isset($_GET['pageNum_userpostedcrime'])) {
  $pageNum_userpostedcrime = $_GET['pageNum_userpostedcrime'];
}
$startRow_userpostedcrime = $pageNum_userpostedcrime * $maxRows_userpostedcrime;
 
 $_SESSION['thisuserid'] = $row_userid['residenceID'];
 $UserID = $row_userid['residenceID'];
  
mysql_select_db($database_crimecon, $crimecon);
$query_userpostedcrime = "SELECT tblcrime.crimeID, tblcrime.dateadded, tblcrime.status, tblsuspect.suspectID, tblvictim.victimID, tblwitness.witnessID, tblsection.sectionnmae FROM tblcrime, tblsuspectcrime, tblsuspect, tblvictim, tblvictimcrime, tblwitness, tblwitnesscrime, tblresidence, tblsection WHERE tblsuspectcrime.crimeID = tblcrime.crimeID  AND tblsuspect.suspectID =  tblsuspectcrime.suspectID   AND tblvictimcrime.crimeID = tblcrime.crimeID   AND tblvictim.victimID =  tblvictimcrime.victimID  AND tblwitnesscrime.crimeID = tblcrime.crimeID  AND tblwitness.witnessID = tblwitnesscrime.witnessID AND tblcrime.complainerID = '{$UserID}'";
$query_limit_userpostedcrime = sprintf("%s LIMIT %d, %d", $query_userpostedcrime, $startRow_userpostedcrime, $maxRows_userpostedcrime);
$userpostedcrime = mysql_query($query_limit_userpostedcrime, $crimecon) or die(mysql_error());
$row_userpostedcrime = mysql_fetch_assoc($userpostedcrime);

if (isset($_GET['totalRows_userpostedcrime'])) {
  $totalRows_userpostedcrime = $_GET['totalRows_userpostedcrime'];
} else {
  $all_userpostedcrime = mysql_query($query_userpostedcrime);
  $totalRows_userpostedcrime = mysql_num_rows($all_userpostedcrime);
}
$totalPages_userpostedcrime = ceil($totalRows_userpostedcrime/$maxRows_userpostedcrime)-1;

mysql_select_db($database_crimecon, $crimecon);
$query_activeeditablecrime = "SELECT tblcrime.crimeID, tblcrime.dateadded, tblcrime.status, tblsection.sectionnmae FROM tblcrime, tblsection WHERE tblsection.sectionID =  tblcrime.sectionID  AND tblcrime.complainerID = '{$UserID}' AND tblcrime.status = 1";
$activeeditablecrime = mysql_query($query_activeeditablecrime, $crimecon) or die(mysql_error());
$row_activeeditablecrime = mysql_fetch_assoc($activeeditablecrime);
$totalRows_activeeditablecrime = mysql_num_rows($activeeditablecrime);

mysql_select_db($database_crimecon, $crimecon);
$query_mostcommonward = "SELECT tblward.wardname, tblcrime.wardID   FROM tblward, tblcrime WHERE tblward.wardID = tblcrime.wardID   ORDER BY tblward.wardID DESC LIMIT 1";
$mostcommonward = mysql_query($query_mostcommonward, $crimecon) or die(mysql_error());
$row_mostcommonward = mysql_fetch_assoc($mostcommonward);
$totalRows_mostcommonward = mysql_num_rows($mostcommonward);

mysql_select_db($database_crimecon, $crimecon);
$query_mostcommonconstituency = "SELECT tblconstituency.constituencyname, tblcrime.constituencyID    FROM tblconstituency, tblcrime  WHERE tblconstituency.constituencyID = tblcrime.constituencyID       ORDER BY  tblconstituency.constituencyID DESC LIMIT 1";
$mostcommonconstituency = mysql_query($query_mostcommonconstituency, $crimecon) or die(mysql_error());
$row_mostcommonconstituency = mysql_fetch_assoc($mostcommonconstituency);
$totalRows_mostcommonconstituency = mysql_num_rows($mostcommonconstituency);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crime dashboard</title>
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/userdashboard.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>
<style type="text/css">
    .homeview{
  height: 100vh;
  width: 100%;
  background: url("assets/logo/background.jpg") no-repeat;
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  font-family: 'Ubuntu', sans-serif;
  padding: 45vh 0;
  text-align: center;
}
nav{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  transition: all 0.4s ease;
  z-index: 1000;
}
.mylinks{
    text-decoration: none;
    color: white;
}

.body-card-holder{
  width: 100%;
  display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.card{
      flex: 1 1 310px; /*  Stretching: */
    flex: 0 1 310px; /*  No stretching: */
    margin: 5px;
}




</style>
<body>
<nav class="shadow-lg p-3 mb-5 bg-body rounded">
   <div class="logoholder">
   	<div class="logo-holder">
   		<img src="assets/logo/logo.png">
   	</div>
   	<div class="name-holder">
   		<h3 class="dodgerblueText">Bungoma county crime logger</h3>
   		<div class="my-nav-holder">
   		

           <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="#">Username</a> -->

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="userdashboard.php">Home</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Report
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="addcrime.php">Crimes</a></li>
            <li><a class="dropdown-item" href="usercrimereport.php">View crime</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['username'] ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="userprofile.php">Profile</a></li>
            <li><a class="dropdown-item" href="usermanual.php">User manual</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>

        
      </ul>
 
    </div>
  </div>
</nav>


   		</div>
   	</div>
   </div>
   </nav>
   <hr>
<br><br><br><br><br><br>
   <div id="user-dashboard">
    <center><h2>Current state if security </h2></center>
    <div class="body-card-holder">
   <div class="card">
    <img src="assets/logo/dangerzone.jpg" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">Danger zone</h5>
        <p class="card-text">
            <label>Constituency level : <?php echo $row_mostcommonconstituency['constituencyname']; ?></label>
            <br>
            <label>Ward level : <?php echo $row_mostcommonward['wardname']; ?></label>
        </p>
       <!--  <a href="" class="btn btn-primary">View more</a> -->
    </div>
   </div>

    <div class="card">
    <img src="assets/logo/onrise.jpg" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">Most crime : <?php echo $row_mostcommoncrime['sectionnmae']; ?></h5>
        <p class="card-text">
		<?php echo $row_mostcommoncrime['description']; ?> 
        </p>
        <!-- <a href="" class="btn btn-primary">View more</a> -->
    </div>
   </div>
   <div class="card">
    <img src="assets/logo/warning.jpg" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">Advice report</h5>
        <p class="card-text">
            Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus.
        </p>
        <!-- <a href="" class="btn btn-primary">View more</a> -->
    </div>
   </div>
   </div>
   </div>
   

<div id="post-crime">
     <center><label class="largeText dodgerblueText">Pending crime post</label></center>
        <div class="main-totalusers"> 
        
        <table id="totalusers">
             <thead>
  <tr>
    <th>Crime Details</th>
    
    <th>Action</th>
    
  </tr>
</thead>
<tbody>
<?php do { ?>
            <tr style="border-bottom: 2px solid dodgerblue;">
                <td style="padding-bottom: 8px;">
                    <label class="smallText dodgerblueText"> ID :  <?php echo $row_activeeditablecrime['crimeID']; ?> , <span> Sec : <?php echo $row_activeeditablecrime['sectionnmae']; ?>,  </span> Date : <?php echo $row_activeeditablecrime['dateadded']; ?>  ,<span> Status : <?php 
                    if ($row_activeeditablecrime['status'] = 1) {
                        // code...
                        echo 'Active';
                    }else{

                    echo 'Closed';
                    }
                     ?></span></label>
                    
                </td>
                <td style="padding-bottom: 8px;"> &nbsp;&nbsp;
                    <button class="mybutton-small"><a href="addvictim.php?editcaseid=<?php echo $row_activeeditablecrime['crimeID'];
                     ?>" class="mylinks">Add Victim</a></button>
                    <button class="mybutton-small"><a href="addsuspect.php?editcaseid=<?php echo $row_activeeditablecrime['crimeID'];
                     ?>" class="mylinks">Add Suspect</a></button>
                    <button class="mybutton-small"><a href="addwitness.php?editcaseid=<?php echo $row_activeeditablecrime['crimeID'];
                     ?>" class="mylinks">Add Witness</a></button>
                </td>

            </tr>
            <?php } while ($row_activeeditablecrime = mysql_fetch_assoc($activeeditablecrime)); ?>
            </tbody>
        </table>
    </div>

</div>

   <div class="scroll-table">
  <div class="table-holder">
    <div class="table-caption">
      <label class="largeText dodgerblueText">Closed crime <span></span></label>
    </div>
    
<table>
    <thead>
  <tr>
    <th>ID</th>
    <th>Section</th>
    <th>dateadded</th>
    <th>status</th>
    <th>suspect ID</th>
    <th>victim ID</th>
    <th>witness ID</th>
  </tr>
</thead>
<tbody>
 
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
                        <p>Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p>
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
mysql_free_result($mostcommoncrime);

mysql_free_result($userid);

mysql_free_result($userpostedcrime);

mysql_free_result($activeeditablecrime);

mysql_free_result($mostcommonward);

mysql_free_result($mostcommonconstituency);
?>
