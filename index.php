<?php 
// Inkluder vores config fil
require_once 'config.php';
 
// Definer tomme variabler
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
     // Tjek om brugernavnsfeltet er tomt
    if(empty(trim($_POST["username"]))){
        $username_err = "Venligst indtast et brugernavn.";
    } else{
        // Forbered en SELECT statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind varable til det forberedte statement som parametre
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parametre
            $param_username = trim($_POST["username"]);
            
            // Forsøg på at køre det forberedte statement
            if(mysqli_stmt_execute($stmt)){
                // Gem resultatet
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Brugernavnet er allerede taget.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Ups! Noget gik galt. Venligst prøv igen senere.";
            }
        }
         
        // Luk statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate kode
    if(empty(trim($_POST['password']))){
        $password_err = "Venligst indtast en kode.";     
    } elseif(strlen(trim($_POST['password'])) < 6){ //antal tegn
        $password_err = "Kodeordet skal være på mindst 6 tegn";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate bekræft kode
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Venligst bekræft kodeordet.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Kodeord er ikke ens.';
        }
    }
    
    // Tjek indtastningsfejl før det bliver sendt ind til databasen
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Forbered en INSERT statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind varable til det forberedte statement som parametre
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parametre
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Laver en kode hash
            
            // Forsøger at køre det forberedte statement
            if(mysqli_stmt_execute($stmt)){
                // Videresender til login siden
                header("location: login.php");
            } else{
                echo "Noget gik galt. Venligst prøv igen senere.";
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
		            <p>Allerede oprettet? Log ind <a href="login.php">her.</a></p>
		</header>
<!--  <article class="main">
    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>  
  </article>-->
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
	  
		        <h2>Oprettelse </h2>
        <p>Udfyld her for at oprette dig.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="formen <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <!--<label>Username:<sup>*</sup></label>-->
                <input type="text" name="username"class="form-control" placeholder="Brugernavn" value="<?php echo $username; ?>">
                
            </div>    
            <div class="formen <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <!--  <label>Password:<sup>*</sup></label>-->
                <input type="password" name="password" class="form-control" placeholder="Kode" value="<?php echo $password; ?>">

            </div>
            <div class="formen <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
             <!--   <label>Confirm Password:<sup>*</sup></label>-->
                <input type="password" name="confirm_password" class="form-control" placeholder="Gentag kode" value="<?php echo $confirm_password; ?>">
				<span class="help-block"><?php echo $username_err; ?></span>
				<span class="help-block"><?php echo $password_err; ?></span>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="formen">
                <input type="submit" class="btn btn-primary" value="Opret">
                <input type="reset" class="btn btn-default" value="Nulstil">
            </div>
            <p>Allerede oprettet? Log ind <a href="login.php"> her.</a></p>
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
		
  <footer class="footer">Dette er en skole produktion.</footer>
</div>
</body>
</html>
