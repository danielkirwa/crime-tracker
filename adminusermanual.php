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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="customcss/admin.css">
<link rel="stylesheet" type="text/css" href="customcss/popupanalysis.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>

<style type="text/css">
	
	.guide-holder{
		display: flex;
		width: 80%;
		margin-left: 10%;
		border: 1px solid dodgerblue;
	}
	.guide-image{

		width: 50%;
		
	}
	.guide-description{

		width: 50%;
		
	}
</style>
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

<br>
<div>
	<div class="guide-holder">
		<div class="guide-image">
         <img src="assets/images/loginguide.png" width="100%">
		</div>
		<div class="guide-description">
             <center><b>Login page</b></center>
             <br>
             <ol>
             	<li>This is the authication page for both admin and normal users</li>
             	<li>You must have registered account before login in to the system</li>
             	<li>Use your Username (Email used to register account)</li>
             	<li>Use your Password (Use your password)</li>
             	<li>Click login button </li>
             	<li>If all your cridential are correct you will be granted access</li>
             </ol>
		</div>
	</div>

<br><br>
<div class="guide-holder">
		<div class="guide-image">
         <img src="assets/images/admindashguide.png" width="100%">
		</div>
		<div class="guide-description">
             <center><b>Admin Dashboard</b></center>
             <br>
             <ol>
             	<li>After login in as an admin dashboard will open </li>
             	<li>You will have a view of all data in the system in an analiesd form</li>
             	<li>You can navigate through the naviagtion bar provided at the top</li>
             	<li>Loged in admin username will be displayed at the top right corner</li>
             	
             </ol>
		</div>
	</div>

<br><br>


<div class="guide-holder">
		<div class="guide-image">
         <img src="assets/images/adaviceaddguide.png" width="100%">
		</div>
		<div class="guide-description">
             <center><b>Post advice</b></center>
             <br>
             <ol>
             	<li>As an admin you can post advice to the residence</li>
             	<li>Click on the username to display more menu including "Add advice tab"</li>
             	<li>Click that "Add Advice tab" to open advice posting page</li>
             	<li>Add advice accodingly and click save</li>
             	<li>Close all absolute advice </li>
             	
             </ol>
		</div>
	</div>

<br><br>

<div class="guide-holder">
		<div class="guide-image">
         <img src="assets/images/crimemanagementguide.png" width="100%">
		</div>
		<div class="guide-description">
             <center><b>Crime Management</b></center>
             <br>
             <ol>
             	<li>On the navigation bar click "Crimes/case" to open more tabs </li>
             	<li>Click on "Crimes" to open the management page to open crimes</li>
             	<li>You will have a clear view of all crims </li>
             	<li>Close all solved all crime to ensure that they clear track are kept</li>
             	<li>You can reopen crims  </li>
             	
             </ol>
		</div>
	</div>

<br><br>


<div class="guide-holder">
		<div class="guide-image">
         <img src="assets/images/crimemanagementguide.png" width="100%">
		</div>
		<div class="guide-description">
             <center><b>User Management</b></center>
             <br>
             <ol>
             	<li>On the navigation bar click "Users" to open management tab </li>
             	<li>You can view all users in the syatem categorised</li>
             	<li>You can close accounts of users of and reopen them</li>
             	
             	
             </ol>
		</div>
	</div>

<br><br>

<div class="guide-holder">
		<div class="guide-image">
         <img src="assets/images/officeraddguide.png" width="100%">
		</div>
		<div class="guide-description">
             <center><b>Add more admin</b></center>
             <br>
             <ol>
             	<li>On the navigation bar click "Officer" to open more tabs and select "Add officers" </li>
             	<li>Added officer will be added </li>
             	<li>Username will be (Email)</li>
             	<li>Password will be (Password)</li>
             	<li>New admin account will be be open and ready to login</li>
             	
             	
             </ol>
		</div>
	</div>

<br><br>


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