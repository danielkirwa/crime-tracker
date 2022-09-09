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
$query_adminAllcrimes = "SELECT tblcrime.crimeID FROM tblcrime";
$adminAllcrimes = mysql_query($query_adminAllcrimes, $crimecon) or die(mysql_error());
$row_adminAllcrimes = mysql_fetch_assoc($adminAllcrimes);
$totalRows_adminAllcrimes = mysql_num_rows($adminAllcrimes);

mysql_select_db($database_crimecon, $crimecon);
$query_adminAllofficer = "SELECT tblofficers.officerID FROM tblofficers";
$adminAllofficer = mysql_query($query_adminAllofficer, $crimecon) or die(mysql_error());
$row_adminAllofficer = mysql_fetch_assoc($adminAllofficer);
$totalRows_adminAllofficer = mysql_num_rows($adminAllofficer);

mysql_select_db($database_crimecon, $crimecon);
$query_adminAlldepartments = "SELECT tbldepartment.departmentId FROM tbldepartment";
$adminAlldepartments = mysql_query($query_adminAlldepartments, $crimecon) or die(mysql_error());
$row_adminAlldepartments = mysql_fetch_assoc($adminAlldepartments);
$totalRows_adminAlldepartments = mysql_num_rows($adminAlldepartments);

mysql_select_db($database_crimecon, $crimecon);
$query_adminAllsection = "SELECT tblsection.sectionID FROM tblsection";
$adminAllsection = mysql_query($query_adminAllsection, $crimecon) or die(mysql_error());
$row_adminAllsection = mysql_fetch_assoc($adminAllsection);
$totalRows_adminAllsection = mysql_num_rows($adminAllsection);

mysql_select_db($database_crimecon, $crimecon);
$query_mostcommoncrime = "SELECT tblcrime.sectionID, tblsection.sectionnmae,  tblsection.`description`  FROM tblcrime, tblsection WHERE tblsection.sectionID = tblcrime.sectionID ORDER BY tblsection.sectionnmae ASC  LIMIT 1";
$mostcommoncrime = mysql_query($query_mostcommoncrime, $crimecon) or die(mysql_error());
$row_mostcommoncrime = mysql_fetch_assoc($mostcommoncrime);
$totalRows_mostcommoncrime = mysql_num_rows($mostcommoncrime);

mysql_select_db($database_crimecon, $crimecon);
$query_activeofficer = "SELECT tblofficers.officerID FROM tblofficers WHERE tblofficers.status = 1";
$activeofficer = mysql_query($query_activeofficer, $crimecon) or die(mysql_error());
$row_activeofficer = mysql_fetch_assoc($activeofficer);
$totalRows_activeofficer = mysql_num_rows($activeofficer);

mysql_select_db($database_crimecon, $crimecon);
$query_activecrimes = "SELECT tblcrime.crimeID FROM tblcrime WHERE tblcrime.status = 1";
$activecrimes = mysql_query($query_activecrimes, $crimecon) or die(mysql_error());
$row_activecrimes = mysql_fetch_assoc($activecrimes);
$totalRows_activecrimes = mysql_num_rows($activecrimes);

mysql_select_db($database_crimecon, $crimecon);
$query_activedepartmets = "SELECT tbldepartment.departmentId FROM tbldepartment WHERE tbldepartment.status = 1";
$activedepartmets = mysql_query($query_activedepartmets, $crimecon) or die(mysql_error());
$row_activedepartmets = mysql_fetch_assoc($activedepartmets);
$totalRows_activedepartmets = mysql_num_rows($activedepartmets);

mysql_select_db($database_crimecon, $crimecon);
$query_activesections = "SELECT tblsection.sectionID FROM tblsection WHERE tblsection.status = 1";
$activesections = mysql_query($query_activesections, $crimecon) or die(mysql_error());
$row_activesections = mysql_fetch_assoc($activesections);
$totalRows_activesections = mysql_num_rows($activesections);

mysql_select_db($database_crimecon, $crimecon);
$query_mostcommonward = "SELECT tblward.wardname, tblcrime.wardID   FROM tblward, tblcrime WHERE tblward.wardID = tblcrime.wardID   ORDER BY  tblward.wardname DESC LIMIT  1";
$mostcommonward = mysql_query($query_mostcommonward, $crimecon) or die(mysql_error());
$row_mostcommonward = mysql_fetch_assoc($mostcommonward);
$totalRows_mostcommonward = mysql_num_rows($mostcommonward);

mysql_select_db($database_crimecon, $crimecon);
$query_mostcommonconstituency = "SELECT tblconstituency.constituencyname, tblcrime.constituencyID    FROM tblconstituency, tblcrime  WHERE tblconstituency.constituencyID = tblcrime.constituencyID       ORDER BY   tblconstituency.constituencyname ASC LIMIT 1";
$mostcommonconstituency = mysql_query($query_mostcommonconstituency, $crimecon) or die(mysql_error());
$row_mostcommonconstituency = mysql_fetch_assoc($mostcommonconstituency);
$totalRows_mostcommonconstituency = mysql_num_rows($mostcommonconstituency);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="customcss/admin.css">
<link rel="stylesheet" type="text/css" href="customcss/popupanalysis.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

<meta name="vartotalcrimes" content="<?php echo $totalRows_adminAllcrimes ?>">
<meta name="vartotalactivecrimes" content="<?php echo $totalRows_activecrimes ?>">
<title>Dashboard</title>
</head>
<style type="text/css">

.enrolls-holder{
  width: 80%;
  margin-left: 10%;
  display: flex;
    flex-wrap: wrap;
    justify-content: center;
}


</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
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
            <?php echo $_SESSION['username'] ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="advice.php">Advice</a></li>
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Reports
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="filter.php">Case Filter</a></li>
            <li><a class="dropdown-item" href="systemusers.php">All Users</a></li>
            
          </ul>
        </li>
       
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
 
 <!-- Start of body -->
 <div class="enrolls-holder">
   <div class="enroll-card hoverme" id="crimebtn">
      <table>
      <tr>
        <td>
          <label class="smallText dodgerblueText">All Crimes : <span id="lbtotalcrimes"> <?php echo $totalRows_adminAllcrimes ?> </span> </label><br/>
          <label>Solved crimes : <span id="lbtotalsolvedcrimes"> <?php echo $totalRows_adminAllcrimes - $totalRows_activecrimes ?> </span> </label><br>
          <label>Unsolved crimes : <?php echo $totalRows_activecrimes ?></label><br>
          <label>Solve rate :  <?php echo ($totalRows_adminAllcrimes - $totalRows_activecrimes)/$totalRows_adminAllcrimes * 100  ?>%</label>
        </td>
      </tr>
    </table>
    </div>



    <div class="enroll-card hoverme" id="crimebtn">
      <table>
      <tr>
        
        <td>
          <label class="smallText dodgerblueText">Danger Zone  : </label><br/>
          <label>Constituency : <?php echo $row_mostcommonconstituency['constituencyname']; ?></label><br>
          <label>Ward :  <?php echo $row_mostcommonward['wardname']; ?></label>
        </td>
      </tr>
    </table>
    </div>

    

    <div class="enroll-card hoverme" id="crimebtn">
      <table>
      <tr>
      
        <td>
          <label class="smallText dodgerblueText">Common Crime :  <?php echo $row_mostcommoncrime['sectionnmae']; ?></label>
          <label class="smallText dodgerblueText">Description : <?php echo $row_mostcommoncrime['description']; ?></label>
        </td>
      </tr>
    </table>
    </div>

     <div class="enroll-card hoverme" id="crimebtn">
      <table>
      <tr>
       
        <td>
          <label class="smallText dodgerblueText">All Officers : <?php echo $totalRows_adminAllofficer ?></label><br/>
          <label class="smallText dodgerblueText">Active Officers :<?php echo $totalRows_activeofficer ?> </label>
          <br/>
          <label class="smallText dodgerblueText">Not Active Officers :<?php echo $totalRows_adminAllofficer - $totalRows_activeofficer ?> </label>
        </td>
      </tr>
    </table>
    </div>

    <div class="enroll-card hoverme" id="crimebtn">
      <table>
      <tr>
        
        <td>
          <label class="smallText dodgerblueText">All Departments : <?php echo $totalRows_adminAlldepartments ?></label><br/>
          <label class="smallText dodgerblueText">Active Departments : <?php echo $totalRows_activedepartmets ?></label><br/>
          <label class="smallText dodgerblueText">Not Active Departments :  <?php echo $totalRows_adminAlldepartments - $totalRows_activedepartmets ?></label>
        </td>
      </tr>
    </table>
    </div>

    <div class="enroll-card hoverme" id="crimebtn">
      <table>
      <tr>
      
        <td>
          <label class="smallText dodgerblueText">All Sections : <?php echo $totalRows_adminAllsection ?></label><br/>
          <label class="smallText dodgerblueText">Active Sections : <?php echo $totalRows_activesections ?></label><br/>
          <label class="smallText dodgerblueText">Not Active Sections : <?php echo $totalRows_adminAllsection - $totalRows_activesections ?></label>
        </td>
      </tr>
    </table>
    </div>


 </div>

 <!-- End of body -->

<!-- POP UP UNIT ANALYSIS -->
  <div class="scroll-analysis">
 
    <div class="analysis-holder">
  <label class="analytic-titel">Visual report crime logger</label>
  <hr>
  <div class="report-holder">
    <div class="report-card">
      
   <label>ALL CRIMES : <span><?php echo $totalRows_adminAllcrimes ?></span></label><br>
   <canvas id="graphallcases" width="50%"></canvas>
    </div>
   <!--  <div class="report-card-long">
      
   <label>RESULTS </label><br>
   <canvas id="barGraphResults" width="50%"></canvas>
    </div> -->
    <!-- <div class="report-card-longer">
      
   <label>GENERAL INFORMATION </label><br>
    <canvas id="barGraphUnitReport" width="50%"></canvas>
   
    </div> -->
  </div>
  
  </div>
</div>

<!-- end of grahp -->



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






<script type="text/javascript" src="customjs/analysis.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
<?php
mysql_free_result($adminAllcrimes);

mysql_free_result($adminAllofficer);

mysql_free_result($adminAlldepartments);

mysql_free_result($adminAllsection);

mysql_free_result($mostcommoncrime);

mysql_free_result($activeofficer);

mysql_free_result($activecrimes);

mysql_free_result($activedepartmets);

mysql_free_result($activesections);

mysql_free_result($mostcommonward);

mysql_free_result($mostcommonconstituency);
?>
