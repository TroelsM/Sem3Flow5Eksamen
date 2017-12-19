<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;      
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
	  
      <h2>Log ind</h2>
        <p>Udfyld her for at logge på.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" placeholder="Brugernavn" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" placeholder="Kodeord"name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
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
		
  <footer class="footer">Dette er en skole produktion.</footer>
</div>
</body>
</html>
