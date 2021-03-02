<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Bitte gebe einen Benutzernamen ein.";
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
                    $username_err = "Dieser Banutzername ist bereits vergeben.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Da lief etwas schief. Versuch es später erneut 1.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Bitte gebe ein Passwort ein";
    } elseif(strlen(trim($_POST["password"])) < 3){
        $password_err = "Dein Passwort muss mindestens 3 Zeichen lang sein.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Bitte bestätige dein Passwort.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Deine Passwörter stimmen nicht überein.";
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

                mkdir("users". DIRECTORY_SEPARATOR .$username);
                mkdir("users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."berichte");
                

                // Redirect to login page
                header("location: login.php");
            } else{
                echo mysqli_stmt_execute($stmt);
                echo "Da lief etwas schief. Versuch es später erneut 2.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="styles/style.css">
    <style type="text/css">
        body{
            font: 14px sans-serif;
            background-color: #272727;
        }
        .wrapper{
            width: 350px; padding: 20px;
            margin: auto;
            background-color: #333333;
            border-radius: 25px;
            margin-top: 20px;
        }
        h2{
            color: #14A76C;
        }
        .btnReady{
            background-color: #14A76C;
            color: #272727;

            padding: 16px 42px;
            box-shadow: 0px 0px 12px -2px rgba(0,0,0,0.5);
            line-height: 1.25;
            text-decoration: none;
            font-size: 16px;
            letter-spacing: .08em;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            font-weight : bold ;
        }
        .btnReset{
            background-color: #FFE400;
            color: #272727;

            padding: 16px 42px;
            box-shadow: 0px 0px 12px -2px rgba(0,0,0,0.5);
            line-height: 1.25;
            text-decoration: none;
            font-size: 16px;
            letter-spacing: .08em;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            font-weight : bold ;
        }
        p{
            color: #747474;
        }
        label{
            color: #FF652F;
        }
        input[type=text]{
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid #FF652F;
            background-color: #272727;
        }
        input[type=password]{
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid #FF652F;
            background-color: #272727;
        }
        @media only screen and (max-device-width : 640px) {
            .wrapper{
                width: 80%; padding: 5%;
                margin: auto;
            }
            h2{
                font-size: 70px;
                text-align: center;
            }

            body{
                font: 30px sans-serif;
            }
            .btnReset{
                font-size: 100%;
            }
            .btnReady{
                font-size: 100%;
            }
            input[type=text]{

            }
            input[type=password]{

            }
        }

    </style>
</head>
<body>
<div class="wrapper">
    <h2>Registrieren</h2>
    <p>Fülle dieses Formular aus um dich zu registrieren.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Benutzername</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Passwort</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Bestätige das Passwort</label>
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btnReady" value="Fertig">
            <input type="reset" class="btnReset" value="Reset">
        </div>
        <p>Hast du bereits einen Account? <a href="login.php">Logge dich hier ein</a>.</p>
    </form>
</div>
</body>
</html>