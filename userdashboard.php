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
$query_mostcommoncrime = "SELECT  tblsection.sectionnmae, tblcrime.sectionID, tblsection.`description` FROM tblsection, tblcrime WHERE tblsection.sectionID = tblcrime.sectionID  ORDER BY tblsection.sectionID DESC LIMIT 1";
$mostcommoncrime = mysql_query($query_mostcommoncrime, $crimecon) or die(mysql_error());
$row_mostcommoncrime = mysql_fetch_assoc($mostcommoncrime);
$totalRows_mostcommoncrime = mysql_num_rows($mostcommoncrime);
mysql_select_db($database_crimecon, $crimecon);
$query_userid = "SELECT tblresidence.residenceID, tblresidence.email FROM tblresidence WHERE tblresidence.email = '{$currentUser}' ";
$userid = mysql_query($query_userid, $crimecon) or die(mysql_error());
$row_userid = mysql_fetch_assoc($userid);
$totalRows_userid = mysql_num_rows($userid);
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
        <h5 class="card-title">Danger zone <?php echo $row_userid['residenceID']; ?></h5>
        <p class="card-text">
            <label>Constituency level : </label><br>
            <label>Ward level : </label>
        </p>
        <a href="" class="btn btn-primary">View more</a>
    </div>
   </div>

    <div class="card">
    <img src="assets/logo/onrise.jpg" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">Most crime : <?php echo $row_mostcommoncrime['sectionnmae']; ?></h5>
        <p class="card-text">
		<?php echo $row_mostcommoncrime['description']; ?> 
        </p>
        <a href="" class="btn btn-primary">View more</a>
    </div>
   </div>
   <div class="card">
    <img src="assets/logo/warning.jpg" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">Advice report</h5>
        <p class="card-text">
            Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus.
        </p>
        <a href="" class="btn btn-primary">View more</a>
    </div>
   </div>
   </div>
   </div>
   
<div id="post-crime">
		<div class="main-totalusers"> 
 		
 		<table id="totalusers">
 			<tr>
 				<td>
 					<label class="smallText dodgerblueText">No. 1, Case name : <span>
 						Victim No. Suspect No1. 12/7/2022 
 					</span></label>
 				</td>
 				<td>
 					<button class="mybutton-small"><a href="addvictim.php" class="mylinks">Add Victim</a></button>
 					<button class="mybutton-small"><a href="addsuspect.php" class="mylinks">Add Suspect</a></button>
 				</td>
 			</tr>
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
?>
