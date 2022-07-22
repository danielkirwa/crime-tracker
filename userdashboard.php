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
.my-nav-holder{
background: #E8EEF1;
padding: 16px;
}
.my-nav-holder a {
	padding: 8px;
	text-decoration: none;
	font-size: 18px;
	color: black;
	border-bottom: 2px solid #E8EEF1;

}
.my-nav-holder a:hover{
	padding: 8px;
	text-decoration: none;
	font-size: 18px;
	color: dodgerblue;
	border-bottom: 2px solid white;

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
   			<a href="#">Home</a>
   			<a href="#">Post</a>
   			<a href="#">Alerts</a>
   			<a href="#">Profile</a>
   			<a href="#">Logout</a>
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
            Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus.
        </p>
        <a href="" class="btn btn-primary">View more</a>
    </div>
   </div>

    <div class="card">
    <img src="assets/logo/onrise.jpg" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">Most crime</h5>
        <p class="card-text">
            Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus.
        </p>
        <a href="" class="btn btn-primary">View more</a>
    </div>
   </div>
   <div class="card">
    <img src="assets/images/danger.jpg" class="card-img-top">
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
 					<button class="mybutton-small">Update</button>
 					<button class="mybutton-small">Add Victim</button>
 					<button class="mybutton-small">Add Suspect</button>
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
</body>
</html>