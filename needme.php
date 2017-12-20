<?php
// Initialize the session
session_start();
 
// Include config file
require_once 'config.php';

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
	


	// Tilmeld
if(isset($_REQUEST['tilmeld'])){
	
	// Tjek om man allerede er tilmeldt
$sql = "SELECT id FROM deltagere WHERE navn = ?";
if($stmt = mysqli_prepare($link, $sql)){
	mysqli_stmt_bind_param($stmt, "s", $param_username);
	$param_username = ($_SESSION["username"]);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1){
			echo 'Du er allerede tilmeldt denne begivenhed';
		}
		else {									
				mysqli_query($link, "INSERT INTO deltagere (navn) VALUES ('{$_SESSION['username']}')");


				}
				if(mysqli_affected_rows($link) > 0){
					echo "Du er nu tilmeldt";
								//antal deltagere
				$sql = "SELECT * FROM deltagere";
				if ($result=mysqli_query($link, $sql))	{
					$rowcount=mysqli_num_rows($result);
					printf ("Result set has %d rows .\n",$rowcount);
				}	
				else {
					echo "Kunne ikke tilmeldes";
				}
			}
		}
	}
}

// Afmeld
if(isset($_REQUEST['afmeld'])){
	// Tjek om man allerede er tilmeldt
$sql = "SELECT id FROM deltagere WHERE navn = ?";
if($stmt = mysqli_prepare($link, $sql)){
	mysqli_stmt_bind_param($stmt, "s", $param_username);
	$param_username = ($_SESSION["username"]);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 0){
			
			echo "Du er ikke tilmeldt denne begivenhed.";
		}
		else {		
			
				mysqli_query($link, "DELETE FROM deltagere WHERE navn = ('{$_SESSION['username']}')");
												// antal deltagere
				$sql = "SELECT * FROM deltagere";
			if ($result=mysqli_query($link, $sql))
			{
				$rowcount=mysqli_num_rows($result);
				echo
				printf ("Result set has %d rows .\n",$rowcount);
			}
							 
				if(mysqli_affected_rows($link) > 0){
					echo "Du er nu afmeldt";


				}	
				else {
					echo "kunne ikke afmeldes.";
				
				}
			}
		}
	}
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="stylustestus.css">
<title>Untitled Document</title>-->
</head>

<body>
	<div class="wrapper">
  		<header class="header">
			<a href="welcome.php"> <img class="logo" src="pics/localplay.png" alt="Logo"></a>
			<ul id="tabs">
	  			<li><a href="welcome.php">Hjem</a></li>	
	  			<li><a href="events.php" class="selected">Events</a></li>	
				<li><a href="logout.php">Log ud</a></li>
	  		</ul>
		</header>	
		<aside class="aside aside-5">
			<p class="eventtekst">
				Så bydes der endnu engang på en Canasta aften i Hvidovre, for sidste måndes sucess skal gentages!<br>
				Grundet stor efterspørgsel sidst, vil der denne gang være 2 spil i gang på en gang!
				<br>
				Det betyder, at vi kan være op til 8 spillere - ny som ekspert er velkomne!<br>
				Regler kan læses her: <a href="http://www.spillemagasinet.dk/spil/canasta/">Regler</a><br><br>
				
				Ligesom sidste gang bager jeg lidt kager til  snack, men i er meget velkomne til også at tage noget med.<br>
				- eventuelt noget at drikke!<br>
				Glæder mig til at se jer!<br>
				Kærlig hilsen Lilje.
			</p>
			<img src="pics/kage.JPG" alt="kage" id="kage">
		</aside>
			
		<aside class="aside aside-6">
			<div class="eventbillede">
				<img src="pics/Dame.jpg" class="profilbillede" alt="profilbillede">
			</div>
			<div class="andetinfo">
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
				<form>
					<input type="submit" name="tilmeld" value="Tilmeld" />
					
					<input type="submit" name="afmeld" value="Afmeld" />
				</form>
				<p class="eventtekst"><b>
					Navn: Lilje Poulsen<br>
					By: Hvidovre 2650<br>
					Adresse: Mørups alle 57<br>
					Dato: 05/01/2018<br>
					Klokken: 19:00<br>
					
					</b></p>
			</div>
			
		</aside>
		<footer class="footer">Dette er en skole produktion.<br>
										  <img class="footerbillede" src="pics/Play Store.svg">
	  <img class="footerbillede" src="pics/App Store.svg">
<h2 class="opmeddig">
	<b>Besøg vores <a  href="https://www.facebook.com/LocalPlay-1493651227418646/">Facebook</a></b>
		</footer>
	</body>
</html>