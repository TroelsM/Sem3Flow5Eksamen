<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
 
// Include config file
require_once 'config.php';
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
		<a href="welcome.php"> <img class="logo" src="pics/localplay.png" alt="Logo"></a>
		<ul id="tabs">
	  		<li><a href="welcome.php">Hjem</a></li>	
	  		<li><a href="events.php" class="selected">Events</a></li>	
			<li><a href="logout.php">Log ud</a></li>
	  	</ul>
		</header>
		<aside class="box box-1">
			<div class="info info-2">
				<p class="eventtekst2"><a href="needme.php"> Så bydes der endnu engang på en Canasta aften i Hvidovre, for sidste måndes sucess skal gentages!<br></a></p>
						<?php
				// antal deltagere
				$sql = "SELECT * FROM deltagere";
				if ($result=mysqli_query($link, $sql))
				{
					$rowcount=mysqli_num_rows($result);
			}
			?>
		<h1>Antal deltagere: <b>
			<?php 
				if ($rowcount>0){
					echo $rowcount; ?></b> / 8</h1><?php
				}
				else
				{
					echo 1 ?></b> / 8</h1><?php
			}  
				?>
			</div>
			<div class="pic pic-2">
				<a href="needme.php"><img src="pics/Dame.jpg" class="pics" alt="profilbillede"></a></div>	
		</aside>
		<aside class="box box-2">
			<div class="info info-2">
				 <p class="eventtekst2"><a href="#">Bring dit allerbedste pokerfjæs
og dine overskydende skillinger og gør klar til kampen om aftenens trone (og gevinst selvfølgelig!)</a></p>
				<h1>Antal deltagere: 2/7 </h1>
			</div>
			<div class="pic pic-2"><a href="#"><img src="pics/pokerguy.jpg" class="pics" alt="Profilbillede"></a></div>
		</aside>
		<aside class="box box-2">
						<div class="info info-2">
				<p class="eventtekst2"><a href="#">Er du typen der sidder og besvarer alle spørgsmålene i Hvem Vil Være Millionær? hjemme i sofaen? Så er dette event for dig! Vi spiller quizspil - primært Bezzerwizzer og Trivial Pursuit</a></p>
							<h1>Antal deltagere: 5/6</h1>
			</div>
			<div class="pic pic-2"><a href="#"><img src="pics/thinker.jpg" class="pics" alt="Profilbillede"></a></div>
		</aside>
		<aside class="box box-2">
					<div class="info info-2">
				<p class="eventtekst2"><a href="#">Er du en haj til kortspi? Så kom og vær med til en super-hygge-aften...</a></p>
						<h1>Antal deltagere: 2/4</h1>
			</div>
			<div class="pic pic-2"><a href="#"><img src="pics/sidstekvinde.jpg" class="pics" alt="pepsilogo"></a></div>
		</aside>
	  <footer class="footer">Dette er en skole produktion </footer>
		   </div>
</body>
</html>