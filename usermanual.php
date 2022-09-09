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
<link rel="stylesheet" type="text/css" href="customcss/myelements.css">
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<title>User Manual</title>
</head>
<style type="text/css">

nav{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  transition: all 0.4s ease;
  z-index: 1000;
}
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
       

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Report
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="addcrime.php">Crimes</a></li>
            <li><a class="dropdown-item" href="usercrimereport.php">View crime</a></li>
          </ul>
        </li>
         <li class="nav-item">
          <a class="nav-link " href="userdashboard.php">Home</a>
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
    
<br><br><br><br><br><br><br><br>
  <hr>


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
         <img src="assets/images/userdash.png" width="100%">
    </div>
    <div class="guide-description">
             <center><b>Admin Dashboard</b></center>
             <br>
             <ol>
              <li>After login in as a user the dashboard will open </li>
              <li>You will have a view of all data in the system in an analiesd form</li>
              <li>You can navigate through the naviagtion bar provided at the top</li>
              <li>Loged in admin username will be displayed at the top right corner</li>
              <li>Your account posts will be displayed out in the dashboard</li>
              
             </ol>
    </div>
  </div>

<br><br>


<div class="guide-holder">
    <div class="guide-image">
         <img src="assets/images/addcrime.png" width="100%">
    </div>
    <div class="guide-description">
             <center><b>Post Crime</b></center>
             <br>
             <ol>
              <li>As a user you can post crime on the system</li>
              <li>Click on the report tab to display more tabs</li>
              <li>Select crime to open crime post page </li>
              <li>fill all the crime details accodingly </li>
              <li>Click on the post button </li>
              
             </ol>
    </div>
  </div>

<br><br>

<div class="guide-holder">
    <div class="guide-image">
         <img src="assets/images/crimemanagementguide.png" width="100%">
    </div>
    <div class="guide-description">
             <center><b>Add Suspect,victim or witness</b></center>
             <br>
             <ol>
              <li>The user dashboad all select on the specific crime </li>
              <li>This will open tha page accoding to the selected button</li>
              <li>Fill the details accodingly and post </li>
              <li>All posted crime and their binded suspect, victim, or witness</li>
              
             </ol>
    </div>
  </div>

<br><br>




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