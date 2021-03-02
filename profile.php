<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome</title>
    <link href="/styles/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts.js"></script>
    <script src="lib/jquery.js" type="text/javascript"></script>
    <script src="lib/jquery.easing.js" type="text/javascript"></script>
    <script src="lib/jqueryFileTree.js" type="text/javascript"></script>
    <link href="styles/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
    <link rel="stylesheet" href="styles/style.css">



    <script type="text/javascript">

        $(document).ready( function() {
            var username = '<?php echo htmlspecialchars($_SESSION["username"]); ?>';
            $('#fileTreeDemo_1').fileTree({ root: '../users/'+username+'/berichte/', script: 'connectors/jqueryFileTree.php' }, function(file) {
                openFile(file);
            });

            $('#fileTreeDemo_2').fileTree({ root: '../users/'+username+'/notizen/', script: 'connectors/jqueryFileTree.php' }, function(file) {
                openFile(file);
            });
            addMonths();


        });

    </script>


</head>

<body>

<div class="topnav" id="myTopnav">
    <a href="index.php">Home</a>
    <a class="active" href="profile.php">Dateien</a>
    <a href="stempeln.php">D-ESS</a>
    <a href="nextcloud.php">Nextcloud Upload</a>
    <a href="defaults.php">Standardeinstellungen</a>
    <a href="reset-password.php">Passwort ändern</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

<div class="content">

    <h2>Dateien</h2>
        <div class="example">
            <h2>Notizen</h2>
            <div id="fileTreeDemo_2" class="demo"></div>
        </div>
        <div class="example">
            <h2>Berichte</h2>
            <div id="fileTreeDemo_1" class="demo"></div>

        </div>

</div>
<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>
</body>
</html>
