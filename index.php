<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crime logger</title>
<link rel="stylesheet" type="text/css" href="customcss/navigation.css">
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
.name-holder a{
    text-decoration: none;
    font-size: 18px;
    padding-left: 8px;
    padding-right: 8px;
    border-bottom: 3px solid white;
    transition: border-bottom 2s;
}
.name-holder a:hover{
    text-decoration: none;
    font-size: 18px;
    padding-left: 8px;
    padding-right: 8px;
    border-bottom: 3px solid dodgerblue;
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
        <a href="login.php">Login</a>
        <a href="addresidence.php">Register</a>
   	</div>
   </div>
   </nav>
   <hr>
   <div>
     <section class="homeview">
          <h1><b style="font-size: 63px; color: crimson;">Bungoma county surveillance</b></h1>

  </section>
   </div>


   <div>
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