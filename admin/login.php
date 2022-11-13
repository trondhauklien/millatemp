<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: profile.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, level FROM users WHERE username = ?";

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
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $level);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["level"] = $level;

                            // Redirect user to welcome page
                            header("location: profile.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
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

$alert = ['reset' => '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Suksess!</strong> Du har nå resatt ditt passord. Logg inn på nytt med det nye passordet ditt.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>', 'logout' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Du har nå logget ut.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'];
?> 

<!DOCTYPE html>
<html lang="nb">
<?php include("../head.php"); ?>
<body>
  <?php include("nav.php"); ?>
    <div class="container">
      <br/>
      <h2>Logg inn</h2>
      <?php echo $alert[$_GET["a"]]; ?>
      <p>Oppgi påloggingsinformasjon for å få tilgang til din side og mer.</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-row">
          <div class="col-md-3">
            <div class="form-group">
                <input type="text" name="username" placeholder="Brukernavn" class="form-control <?php if(!empty($username_err)){echo 'is-invalid';} ?>" value="<?php echo $username; ?>">
                <div class="invalid-feedback">
                  <?php echo $username_err; ?>
                </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                <input type="password" name="password" placeholder="Passord" class="form-control <?php if(!empty($password_err)){echo 'is-invalid';} ?>">
                <div class="invalid-feedback">
                  <?php echo $password_err; ?>
                </div>
            </div>
          </div>
          <div class="col-auto">
            <div class="form-group">
              <input type="submit" class="form-control btn btn-primary" value="Logg inn">
            </div>
          </div>
        </div>
          <p>Har du ikke konto? <a href="register.php">Registrer deg nå</a>.</p>
      </form>
    </div>
<?php include("../footer.php"); ?>
</body>
</html>
