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
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
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


        Date.prototype.getWeek = function() {
        var onejan = new Date(this.getFullYear(),0,1);
        return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
        }

            dt = new Date();
            console.log(ISO8601_week_no(dt));

        var today = new Date();
        var week = today.getWeek();
        document.getElementById("headWeek").innerHTML= ISO8601_week_no(dt);
        document.getElementById("masse").value = week;
        if(week>=6){
            document.getElementById("groesse").value = week
        }else{
            document.getElementById("groesse").value = 1;
        }
        loadDefaults();
            

        });

        
    </script>
    <style>




    </style>
</head>
<body>
<div class="topnav" id="myTopnav">
    <a class="active"  href="index.php">Home</a>
    <a href="profile.php">Dateien</a>
    <a href="stempeln.php">D-ESS</a>
    <a href="nextcloud.php">Nextcloud Upload</a>
    <a href="defaults.php">Standardeinstellungen</a>
    <a href="reset-password.php">Passwort ändern</a>
    <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i></a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>
<div class="content">
    <div class="page-header">
        <h1>Hallo, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. </h1>
        <h1>Wir haben KW: <p id="headWeek" "></p>
        </h1>


    </div>

    <div class="flex-container">
        <div id="doForm" class="mainDivs">
            <div id="doInputForm">
                <h2>Notizen anlegen</h2>
                <form class="genTable">
                    <label for="yearNote">Jahr:</label>
                    <input class="formField" id="yearNote" type="number" min="2020" max="2020" step="1" value="2021"
                           onchange="loader()">

                        <label>Betriebliche Tätigkeiten:</label>
                        <textarea id="betrieb" name="w3review" rows="4" cols="35" "></textarea>



                        <label>Unterweisungen:</label>
                        <textarea id="unterweisungen" name="w3review" rows="4" cols="35"></textarea>



                        <label>Berufsschule:</label>
                        <textarea id="schule" name="w3review" rows="4" cols="35"></textarea>


                    <button type="button" class="fBtn"
                            onclick="addDos()">
                        Abschicken
                    </button>

                    <div id="showCurrent">
                        <label for="apple-switcher2">Bearbeite ältere Notizen</label>
                        <input class="apple-switch" id="apple-switcher2" onchange="showCurrent()" type="checkbox">
                    </div>
                </form>

            </div>

            <div id="oldNotes">
                <h2>Ältere Notizen</h2>
                <form class="genTable">
                    <label for="selectWeek">gewählte Kalenderwoche:</label>
                    <input class="formField" id="selectWeek" type="number" min="1" max="54" step="1" value="8"
                           onchange="loader()">
                    <label>Betriebliche Tätigkeiten:</label>
                        <textarea id="betriebNotes" class="vorhandeneNotes" rows="4" cols="35"></textarea>
                    <label>Unterweisungen:</label>
                        <textarea id="unterweisungNotes" class="vorhandeneNotes" rows="4" cols="35"></textarea>
                    <label>Berufsschule:</label>
                        <textarea id="schulNotes" class="vorhandeneNotes" rows="4" cols="35"></textarea>

                    <button type="button" class="fBtn"
                            onclick="editDos()">
                        Speichern
                    </button>
                    <div id="datenKlauen">
                        <label for="apple-switcher3">Daten klauen</label>
                        <input class="apple-switch" id="apple-switcher3" onchange="showDatenKlauen()" type="checkbox">
                    </div>
                </form>
            </div>

            <div id="klauenDiv">
                <h2>Daten klauen</h2>
                <p>Es werden Daten zu der oben angegebene Kalenderwoche geklaut.</p>
                <form class="genTable">
                    <label>Notizenart:</label>
                    <select class="formField" id="klauArt" maxlength="100">
                        <option value="Betrieb">Betrieb</option>
                        <option value="Unterweisung">Unterweisung</option>
                        <option value="Schule">Schule</option>

                    </select>
                    <label>Benutzer:</label>
                    <select class="formField" id="klauUser" maxlength="100"></select>


                    <button type="button" class="fBtn"
                            onclick="klauenSubmit()">
                        Klauen
                    </button>
                </form>
            </div>
        </div>


        <div id="berichte" class="mainDivs">


            <div class="theForm">
                <h2>Berichte generieren</h2>


                <form class="genTable">
                    <label for="vorname">Vorname:</label>
                    <input type="text" class="formField" id="vorname" name="vorname" maxlength="100">

                    <label for="Nachname">Nachname:</label>
                    <input type="text" class="formField" id="Nachname" name="name" maxlength="100">

                    <label for="groesse">Startwoche:</label>
                    <input class="formField" id="groesse" type="number" min="1" max="52" step="1" value="1">

                    <label for="masse">Endwoche:</label>
                    <input class="formField" id="masse" type="number" min="1" max="52" step="1" value="8">

                    <label for="year">Jahr:</label>
                    <input class="formField" id="year" type="number" min="2020" max="2021" step="1" value="2021">


                    <button type="button" class="fBtn"
                            onclick="generate(document.getElementById('vorname').value, document.getElementById('Nachname').value, document.getElementById('groesse').value, document.getElementById('masse').value, document.getElementById('year').value)">
                        Berichte generieren
                    </button>
                </form>
            </div>

            <div class="explain">
                <H3>Erklärung</H3>
                <p>
                    In dem Formular oben könnt ihr eure Daten eintragen. Mit einem Klick auf "Berichte generieren"
                    werden denn die Berichte erzeugt.<br>
                    Mit jedem Klick werden die vorherigen Berichte überschrieben. <br>
                    Sollten für die jeweiligen Wochen Notizen vorhanden sein (müssen unten erstellt worden sein), werden
                    diese automatisch in die Berichte eingetragen. <br>
                    Nach einem Neuladen der Seite werden die Berichte unten im Bereich "Berichte" angezeigt.
                </p>
            </div>
        </div>


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
