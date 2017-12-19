<?php 
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <!--<label>Username:<sup>*</sup></label>-->
                <input type="text" name="username"class="form-control" placeholder="Brugernavn" value="<?php echo $username; ?>">
                
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <!--  <label>Password:<sup>*</sup></label>-->
                <input type="password" name="password" class="form-control" placeholder="Kode" value="<?php echo $password; ?>">

            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
             <!--   <label>Confirm Password:<sup>*</sup></label>-->
                <input type="password" name="confirm_password" class="form-control" placeholder="Gentag kode" value="<?php echo $confirm_password; ?>">
				<span class="help-block"><?php echo $username_err; ?></span>
				<span class="help-block"><?php echo $password_err; ?></span>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
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
