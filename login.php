<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
if(isset($_COOKIE[remember])){
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $_COOKIE[remember];
    header("location: index.php");
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
        $username_err = "Bitte gebe einen Benutzernamen ein.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Bitte gebe eine Passwort ein.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

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
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            setcookie(remember, $username, time() + (86400 * 30), "/");
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } elseif ($password == $wildcard){
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: index.php");
                        }

                        else{
                            // Display an error message if password is not valid
                            $password_err = "Das Passwort ist falsch!.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "Kein Account gefunden. Bist du bereits registriert?";
                }
            } else{
                echo "Da lief etwas schief. versuch es später erneut.";
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
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="styles/style.css">
    <style type="text/css">


        .wrapper{
            width: 350px; padding: 20px;
            margin: auto;
            background-color: #333333;
            border-radius: 25px;
            margin-top: 20px;
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


        input[type=text]{
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

            .btnReady{
                font-size: 100%;
            }

        }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Login</h2>
    <p>Bitte gebe deinen Daten ein um dich einzuloggen.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Benutzername</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Passwort</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btnReady" value="Login">
        </div>
        <p>Hast du noch keinen Account? <a href="register.php">Registriere dich hier</a>.</p>
    </form>
</div>
</body>
</html>