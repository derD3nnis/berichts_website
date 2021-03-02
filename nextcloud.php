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
            addYears();
            addMonths("2020");


        });

    </script>

    <style>

    </style>
</head>

<body>

<div class="topnav" id="myTopnav">
    <a href="index.php">Home</a>
    <a href="profile.php">Dateien</a>
    <a href="stempeln.php">D-ESS</a>
    <a class="active" href="nextcloud.php">Nextcloud Upload</a>
    <a href="defaults.php">Standardeinstellungen</a>
    <a href="reset-password.php">Passwort ändern</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

<div class="content">

    <p style="margin-top: 15px">
        Hast du bereits einen G-Key Nextcloud Account?<br>
        Wenn nicht klicke <a href="https://cloud.g-key.de">hier</a> um dich zu registrieren.
    </p>

    <div class="mainDivs">


        <h2>Dateien in Nextcloud laden</h2>


        <form class="genTable">
            <label for="webUsername">Nextcloud Benutzername:</label>
            <input type="text" class="formField" id="webUsername" maxlength="100">

            <label for="webPassword">Nextcloud Passwort:</label>
            <input class="formField" id="webPassword" maxlength="100" type="password">

            <label for="webTarget">Jahr:</label>
            <select class="formField" id="webYear" maxlength="100" value="2020" onchange="addMonths(value)"></select>

            <label for="webTarget">Monat:</label>
            <select class="formField" id="webMonth" maxlength="100"></select>

            <label for="webFolder">Ordner:</label>
            <input type="text" class="formField" id="webFolder" maxlength="100" value="berichte">

            <button type="button" class="fBtn"
                    onclick="webdavUpload()">
                Upload
            </button>
        </form>


    </div>
    <div class="mainDivs">
        <h1>Live Console</h1>
        <iframe src="testPhp.php" scrolling="auto"></iframe>
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