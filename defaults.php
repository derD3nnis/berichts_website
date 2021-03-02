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
    <link rel="stylesheet" href="styles/style.css">

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

            $.ajax({
                method: 'get',
                url: 'php_functions/telegramKey.php',
                data: {
                    'clear': true
                },
                success: function(data) {
                    document.getElementById("telegramKey").innerText = data;

                }
            })

            $.ajax({
                method: 'get',
                url: 'php_functions/loadDefaults.php',
                data: {
                    'add': true,


                },

                success: function(data) {
                    var rows = data.split("$");



                    if(rows.length>1){

                        document.getElementById("defaultVorname").value = rows[0];
                        document.getElementById("defaultNachname").value = rows[1];
                        document.getElementById("defaultGerade").value = rows[2];
                        document.getElementById("defaultUngerade").value = rows[3];
                        document.getElementById("defaultWorkWay").value = rows[4];

                    }



                }
            })

        });

    </script>

    <style>
        .mainDivs{
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="topnav" id="myTopnav">
    <a href="index.php">Home</a>
    <a href="profile.php">Dateien</a>
    <a href="stempeln.php">D-ESS</a>
    <a href="nextcloud.php">Nextcloud Upload</a>
    <a class="active" href="defaults.php">Standardeinstellungen</a>
    <a href="reset-password.php">Passwort ändern</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

<div class="content">
    <div class="mainDivs">
        <h2>Standards bearbeiten</h2>
        <form id="defaultForm">
            <label for="defaultVorname">Vorname:</label>
            <input type="text" class="formField" id="defaultVorname" maxlength="100">

            <label for="defaultNachname">Nachname:</label>
            <input type="text" class="formField" id="defaultNachname" maxlength="100">

            <label for="defaultGerade">Schulstunden in geraden Wochen:</label>
            <input class="formField" id="defaultGerade" type="number" min="1" max="52" step="1" value="8">

            <label for="defaultUngerade">Schulstunden in ungeraden Wochen</label>
            <input class="formField" id="defaultUngerade" type="number" min="1" max="52" step="1" value="16">

            <label for="defaultWorkWay">Weg zur Arbeit</label>
            <input class="formField" id="defaultWorkWay" type="number" min="1" max="59" step="1" value="25">


            <button type="button" class="fBtn"
                    onclick="addDefaults()">
                Speichern
            </button>
        </form>
    </div>
    <h2>Telegram Key</h2>
    <p id="telegramKey">Test</p>



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
