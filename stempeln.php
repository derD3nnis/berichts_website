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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js" type="text/javascript"></script>


    <script type="text/javascript">

        $(document).ready( function() {
            eingestempelt = false;
            var today = new Date();
            if(today.getMinutes()<10){
                minutes = '0' + today.getMinutes();
            } else{
                minutes = today.getMinutes();
            }

            if(today.getHours()<10){
                hours = '0' + today.getHours();
            } else {
                hours = today.getHours();
            }
            var time = hours + ":" + minutes;
            document.getElementById("stempelTime").value = time;

            $.ajax({
                method: 'get',
                url: 'php_functions/stempelzeit.php',
                data: {
                    'clear': true
                },
                success: function(data) {
                    if(data.toString() == "nix"){
                        eingestempelt = false;
                    } else{
                        eingestempelt = true;
                        document.getElementById("stempeln").innerText = "Ausstempeln";
                        document.getElementById("stempelText").innerText = "Du bist eingestempelt seit: " + data;
                    }



                }
            });

            $.ajax({
                method: 'get',
                url: 'php_functions/loadDefaults.php',
                data: {
                    'add': true,


                },

                success: function(data) {
                    var rows = data.split("$");

                    if(rows.length>1){
                        document.getElementById("ess_default_waytime").value = rows[4] + " Minuten";
                    }



                }
            })

        });

    </script>

    <style>




    </style>
</head>

<body>

<div class="topnav" id="myTopnav">
    <a href="index.php">Home</a>
    <a href="profile.php">Dateien</a>
    <a class="active" href="stempeln.php">D-ESS</a>
    <a href="nextcloud.php">Nextcloud Upload</a>
    <a href="defaults.php">Standardeinstellungen</a>
    <a href="reset-password.php">Passwort ändern</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

<div class="content">
    <h2>D-ESS</h2>
    <p>Ein funktionierendes Zeit-Management System</p>
    <a href="users/<?php echo htmlspecialchars($_SESSION["username"]); ?>/zeiten.csv"><b>Zeiten</b></a>
    <p id="stempelText">Du bist aktuell nicht eingestempelt.</p>

    <div class="flex-container">


        <div class="mainDivs">
            <form id="defaultForm">

                <label for="stempelTime">Uhrzeit:</label>
                <input class="formField" id="stempelTime" type="time">

                <label for="defaultGerade">Ort:</label>
                <input class="formField" id="defaultGerade" type="text">




                <button id="stempeln" type="button" class="fBtn" onclick="stm()">
                    Einstempeln
                </button>
            </form>

        </div>

        <h2>Advanced ESS</h2>
        <div class="mainDivs" style="margin-bottom: 20px; display: flex; flex-direction: column">


            <table>


                <tr>
                    <td><label for="date_ess">Datum:</label></td>
                    <td><input class="formField" id="date_ess" type="date" onchange="ess_date_change()"></td>
                </tr>

                <tr class="ess_from_home">
                    <td><label for="home1_starttime">Home Startzeit:</label></td>
                    <td><input class="formField" id="home1_starttime" type="time"></td>
                </tr>

                <tr class="ess_from_home">
                    <td><label for="home1_traveltime">Reisezeit Start:</label></td>
                    <td><input class="formField" id="home1_traveltime" type="time"></td>
                </tr>

                <tr>
                    <td><label for="work_starttime">Arbeit Start:</label></td>
                    <td><input class="formField" id="work_starttime" type="time"></td>
                </tr>


                <tr>
                    <td><label for="work_endtime">Arbeit Ende:</label></td>
                    <td><input class="formField" id="work_endtime" type="time"></td>
                </tr>

                <tr>
                    <td><label for="work_traveltime">Zuhause angekommen:</label></td>
                    <td><input class="formField" id="work_traveltime" type="time"></td>
                </tr>

                <tr>
                    <td><label for="home2_end">Homeoffice Ende:</label></td>
                    <td><input class="formField" id="home2_end" type="time"></td>
                </tr>

                <tr>
                    <td><label for="ess_startkm">Start Kilometer:</label></td>
                    <td><input class="formField" id="ess_startkm" type="number"></td>
                </tr>

                <tr>
                    <td><label for="ess_endkm">End Kilometer:</label></td>
                    <td><input class="formField" id="ess_endkm" type="number"></td>
                </tr>

                <tr>
                    <td><label for="ess_kontakt">Kontaktpersonen:</label></td>
                    <td><input class="formField" id="ess_kontakt" type="text"></td>
                </tr>

                <tr>
                    <td><label for="ess_orte">Orte:</label></td>
                    <td><input class="formField" id="ess_orte" type="text"></td>
                </tr>

                <tr>
                    <td><label for="ess_taten">Tätigkeiten:</label></td>
                    <td><input class="formField" id="ess_taten" type="text"></td>
                </tr>
                <tr>
                    <td><label for="ess_default_waytime">Weg nach Plaidt:</label></td>
                    <td><input class="formField" id="ess_default_waytime" type="text" readonly></td>
                </tr>



            </table>
            <br>
            <button type="button" class="fBtn" onclick="arbeitszeit_speichern()" style="margin-bottom: 10px">
                Speichern
            </button>
        </div>

        <button type="button" class="fBtn" onclick="generateContactDo()" style="margin-bottom: 10px">
            Liste generieren
        </button>

        <h2>Arbeitszeit erfassen</h2>

        <div class="mainDivs" style="margin-bottom: 20px; display: flex; flex-direction: column">


            <table>
                <tr id="ess_tbl_home1">
                    <td>HOME:</td>
                    <td><p id="ess_home1"></p></td>
                    <td><p id="ess_home1_calc"></p></td>
                </tr>

                <tr>
                    <td>ANW:</td>
                    <td><p id="ess_anw"></p></td>
                    <td><p id="ess_anw_calc"></p></td>
                </tr>

                <tr id="ess_tbl_home2">
                    <td>HOME:</td>
                    <td><p id="ess_home2"></p></td>
                    <td><p id="ess_home2_calc"></p></td>
                </tr>

                <tr>
                    <td>Arbeitszeit:</td>
                    <td><p id="ess_calc"></p></td>
                </tr>



            </table>

        </div>

        <h2>Reisezeit erfassen</h2>
        <div class="mainDivs" style="margin-bottom: 20px; display: flex; flex-direction: column">


            <table>
                <tr>
                    <td>Reisezeit:</td>
                    <td><p id="ess_reis_time"></p></td>
                </tr>

                <tr>
                    <td>Kilometer:</td>
                    <td><p id="ess_reis_km"></p></td>
                </tr>

                <tr>
                    <td>Orte:</td>
                    <td><p id="ess_reis_orte"></p></td>
                </tr>



            </table>

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
