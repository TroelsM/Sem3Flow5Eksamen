<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
?>
 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
	    <link rel="stylesheet" href="stylustestus.css">
<title>Untitled Document</title>
</head>

<body>
	<div class="wrapper-2">
  	<header class="header">
		<a href="#"> <img class="logo" src="pics/localplay.png" alt="Logo"></a>
		<ul id="tabs">
	  		<li><a class="selected" href="welcome.php">Hjem</a></li>	
	  		<li><a href="events.php">Events</a></li>
			<li><a href="logout.php">Log ud</a></li>	
	  	</ul>
	</header>
		<aside class="aside aside-3">
				<h1>Velkommen til LocalPlay, <b><?php echo $_SESSION['username']; ?></b>. </h1>	
			<br>
			<p class="eventtekst">
				Her har du muligheden for at finde andre spillere, der er interesserede i de samme yndlingsspil som dig!<br>
				
				Find events i dit lokalområde eller opret et selv og udvid dit spillenetværk!<br>
				<br>
				
			</p>
			<div class="billeder">
				<img class="spilbillede" src="pics/bezzerwizzer.png" alt="Bezzerwizzer">
				<img class="spilbillede" src="pics/kortspil.png" alt="Kort">
				<img class="spilbillede" src="pics/matador.png" alt="Matador">
    </div>

		</aside>
		<aside class="aside aside-4"></aside>
		<footer class="footer">Dette er en skole produktion.<br>
										  <img class="footerbillede" src="pics/Play Store.svg">
	  <img class="footerbillede" src="pics/App Store.svg">
<h2 class="opmeddig">
	<b>Besøg vores <a  href="https://www.facebook.com/LocalPlay-1493651227418646/">Facebook</a></b>
		</footer>
</body>
</html>