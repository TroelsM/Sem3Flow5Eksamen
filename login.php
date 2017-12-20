<?php
// Inkluder vores config fil
require_once 'config.php';
 
// Definer tomme variabler
$username = $password = "";
$username_err = $password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Tjek om brugernavnsfeltet er tomt
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Tjek om kodefeltet er tomt
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // bekræft indtastede
    if(empty($username_err) && empty($password_err)){
        // Forbered en SELECT statement
        $sql = "SELECT username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind varable til det forberedte statement som parametre
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parametre
            $param_username = $username;
            
            // Forsøg på at køre det forberedte statement
            if(mysqli_stmt_execute($stmt)){
                // Gem resultat
                mysqli_stmt_store_result($stmt);
                
                // Tjek om brugernavnet eksistere - hvis ja, så bekræft koden.
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind resultatet til variable
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Koden er korrekt, så start en ny session og<br>
							gem brugernavnet til sessionen */
                            session_start();
                            $_SESSION['username'] = $username;      
                            header("location: welcome.php");
                        } else{
                            // Vis en fejl hvis koden er inkorrekt
                            $password_err = 'Koden du skrev er ikke korrekt.';
                        }
                    }
                } else{
                    // Vis en fejl hvis brugernavn ikke eksistere
                    $username_err = 'Ingen bruger fundet med det brugernavn.';
                }
            } else{
                echo "Ups! Noget gik galt. Venligst prøv igen senere.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
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
	
	<div class="wrapper">
  <header class="header">
	  <a href="index.php"> <img class="logo" src="pics/localplay.png" alt="Logo"></a>
		                       <p>Ikke oprettet? Opret dig <a href="index.php">her!</a>.</p>
		</header>
  <aside class="aside aside-1">
	  
	  		Elsker du også hyggeaftener
med brætspil, kortspil eller lignende?<br>
			
Mangler DU også nogle at spille med?<br>

Så er du kommet til det rigtige sted!<br>
	  
	  Mange andre har allerede fundet nye spillepartnere.<br><br>
	  
	  Vil du også være med, så meld dig ind her!
	  <br>
	  <br>
	  <br>
	 <img class="spilbillede2" src="pics/bezzerwizzer.png" alt="bezzerwizzer">
		</aside>
  <aside class="aside aside-2">
	  <div class="signup">
	  
      <h2>Log ind</h2>
        <p>Udfyld her for at logge på.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="formen <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" placeholder="Brugernavn" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="formen <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" placeholder="Kodeord"name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="formen">
                <input type="submit" class="btn btn-primary" value="Log ind">
            </div>
            <p>Ikke oprettet? Opret dig <a href="index.php">her</a>.</p>
        </form>
		  </div>
	  	  <h2>
	  	<b>Download vores app her:</b>
	  </h2>
	  <img class="appbillede" src="pics/Play Store.svg">
	  <img class="appbillede" src="pics/App Store.svg">
<h2>
	<b>Besøg vores <a href="https://www.facebook.com/LocalPlay-1493651227418646/">Facebook</a></b>
	  </h2>
		</aside>
		
  <footer class="footer">Dette er en skole produktion.

		</footer>
</div>
</body>
</html>
