function addRow(file, user) {
    var table = document.getElementById("table");
    var rows = table.rows;
    var length = rows.length;
    var row = table.insertRow(length);
    var cell1 = row.insertCell(0);
    var content = document.createElement('a');
    var linkText = document.createTextNode(file);
    content.appendChild(linkText);
    content.href = "http://bericht.g-key.de" + "/users/" + user+ "/berichte/" + file;
    content.target = "_blank";
    cell1.appendChild(content);

}
function generate(vor, nach, start, end, year) {

    var name = vor + "_" + nach;

    $.ajax({
        method: 'get',
        url: 'php_functions/generate.php',
        data: {
            'generate': true,
            'name': name,
            'start': start,
            'end': end,
            'year': year
        },
        success: function(data) {
            console.log(data);
            window.alert("Berichte wurden generiert");
        },error: function (request, status, error) {
            console.log(request.responseText);
            console.log(error);
        }
    })
}

function openFile(file) {
    window.open(file);

}

function doSth() {
    $.ajax({
        method: 'get',
        url: 'php_functions/clear.php',
        data: {
            'clear': true
        },
        success: function(data) {


        }
    })
}

function addDos() {
    var betrieb = document.getElementById("betrieb").value;
    var unterweisungen = document.getElementById("unterweisungen").value;
    var schule = document.getElementById("schule").value;
    var kw = 'current';
    var year = document.getElementById("yearNote").value;

    $.ajax({
        method: 'get',
        url: 'php_functions/addNote.php',
        data: {
            'add': true,
            'betrieb': betrieb,
            'unterweisungen': unterweisungen,
            'schule': schule,
            'kw': kw,
            'mode': "a",
            'year': year
        },

        success: function(data) {
            document.getElementById("betrieb").value = '';
            document.getElementById("unterweisungen").value = "";
            document.getElementById("schule").value = "";
            window.alert("Daten eingetragen");
            window.alert(data);
            console.log(data);


        }
    })
}

function loadBetrieb(week) {
    var kw = week;
    var year = document.getElementById("yearNote").value;
    $.ajax({
        method: 'get',
        url: 'php_functions/getBetrieb.php',
        data: {
            'betrieb': true,
            'kw': kw,
            'year': year


        },

        success: function(data) {
            document.getElementById("betriebNotes").value = data;

        }
    })

}

function loadUnterweisung(week) {
    var kw = week;
    var year = document.getElementById("yearNote").value;
    $.ajax({
        method: 'get',
        url: 'php_functions/getUnterweisung.php',
        data: {
            'betrieb': true,
            'kw': kw,
            'year': year

        },

        success: function(data) {
            document.getElementById("unterweisungNotes").value = data;

        }
    })

}

function loadSchule(week) {
    var kw = week;
    var year = document.getElementById("yearNote").value;
    $.ajax({
        method: 'get',
        url: 'php_functions/getSchule.php',
        data: {
            'betrieb': true,
            'kw': kw,
            'year': year

        },

        success: function(data) {
            document.getElementById("schulNotes").value = data;

        }
    })

}

function showExplain() {

    if(document.getElementById("apple-switcher").checked == true){
        document.getElementsByClassName("explain")[0].style.display = 'block';
        document.getElementsByClassName("explain")[1].style.display= 'block';
    }
    else{
        document.getElementsByClassName("explain")[0].style.display = 'none';
        document.getElementsByClassName("explain")[1].style.display= 'none';
    }

}

function showCurrent() {

    if(document.getElementById("apple-switcher2").checked == true){
        document.getElementById("oldNotes").style.display = 'block';
        Date.prototype.getWeek = function() {
            var onejan = new Date(this.getFullYear(),0,1);
            return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
        }

        var today = new Date();
        var week = today.getWeek();
        document.getElementById("selectWeek").value = week;
        loader(week);

    }
    else{
        document.getElementById("oldNotes").style.display = 'none';
    }

}
function loader(){
    week = document.getElementById("selectWeek").value;
    loadBetrieb(week);
    loadUnterweisung(week);
    loadSchule(week);
}
function editDos() {
    var betrieb = document.getElementById("betriebNotes").value;
    var unterweisungen = document.getElementById("unterweisungNotes").value;
    var schule = document.getElementById("schulNotes").value;
    var kw = document.getElementById("selectWeek").value;
    var year = document.getElementById("yearNote").value;

    $.ajax({
        method: 'get',
        url: 'php_functions/addNote.php',
        data: {
            'add': true,
            'betrieb': betrieb,
            'unterweisungen': unterweisungen,
            'schule': schule,
            'kw': kw,
            'mode': "w",
            'year': year
        },

        success: function(data) {
            window.alert("Notizen erfolgreich aktualisiert");


        }
    })
}

function editDefaults() {

    if(document.getElementById("apple-switcher3").checked == true){
        document.getElementById("defaults").style.display = 'block';

    }
    else{
        document.getElementById("defaults").style.display = 'none';
    }

}

function addDefaults(){
    var vorname = document.getElementById("defaultVorname").value;
    var nachname = document.getElementById("defaultNachname").value;
    var gerade = document.getElementById("defaultGerade").value;
    var ungerade = document.getElementById("defaultUngerade").value;
    var wegZurArbeit = document.getElementById("defaultWorkWay").value;

    $.ajax({
        method: 'get',
        url: 'php_functions/addDefault.php',
        data: {
            'add': true,
            'vorname': vorname,
            'nachname': nachname,
            'gerade': gerade,
            'ungerade': ungerade,
            'defaultWorkWay': wegZurArbeit

        },

        success: function(data) {
            window.alert("Daten eingetragen");


        }
    })
}

function loadDefaults() {
    $.ajax({
        method: 'get',
        url: 'php_functions/loadDefaults.php',
        data: {
            'add': true,


        },

        success: function(data) {
            var rows = data.split("$");



            if(rows.length>1){

                document.getElementById("vorname").value = rows[0];
                document.getElementById("Nachname").value = rows[1];
            }



        }
    })
}

function webdavUpload() {
    var username = document.getElementById("webUsername").value;
    var password = document.getElementById("webPassword").value;
    var year = document.getElementById("webYear").value;
    var month = document.getElementById("webMonth").value;
    var webFolder = document.getElementById("webFolder").value;
    window.alert("Der Upload dauert einen Moment. Du bekommst eine Meldung wenn er abgeschlossen ist.")
    $.ajax({
        method: 'get',
        url: 'webdavUpload.php',
        data: {
            'add': true,
            'username': username,
            'password': password,
            'year': year,
            'month': month,
            'webFolder': webFolder,

        },

        success: function(data) {
            window.alert("Dateien wurden hochgeladen");


        },
        error: function (request, status, error) {
            window.alert(request.responseText);
        }


    })

}
function addYears() {
    $.ajax({
        method: 'get',
        url: 'php_functions/getYears.php',
        data: {
            'add': true,

        },

        success: function(data) {
            var months = data.toString().split(",");
            months.forEach(function (item, index) {
                var option = document.createElement("option");
                option.text = item;
                document.getElementById("webYear").add(option);
            })


        }

    })
}
function addMonths(year) {
    var select = document.getElementById("webMonth");
    var length = select.options.length;
    for (i = length-1; i >= 0; i--) {
        select.options[i] = null;
    }
    select.value = null;
    console.log("Jahr: " + year);
    $.ajax({
        method: 'get',
        url: 'php_functions/getMonths.php',
        data: {
            'add': true,
            'year': year

        },

        success: function(data) {
            console.log("Months: " + data);
            var months = data.toString().split(",");
            months.forEach(function (item, index) {
                var option = document.createElement("option");
                option.text = item;
                document.getElementById("webMonth").add(option);
            })


        }

    })
}

function stm() {
    var zeit = '01/01/1970 ' + document.getElementById("stempelTime").value;
    var time = new Date(zeit);
    if(time.getMinutes()<10){
        minutes = '0' + time.getMinutes();
    } else{
        minutes = time.getMinutes();
    }

    if(time.getHours()<10){
        hours = '0' + time.getHours();
    } else {
        hours = time.getHours();
    }
    var timeString = hours + ":"+minutes;

    if(eingestempelt){
        $.ajax({
            method: 'get',
            url: 'php_functions/ausstempeln.php',
            data: {
                'add': true,
                'time': timeString

            },

            success: function(data) {
                $.ajax({
                    method: 'get',
                    url: 'php_functions/clearTime.php',
                    data: {
                        'add': true,

                    },

                    success: function(data) {
                        window.alert("Ausgestempelt");
                        location.reload();
                    }

                })
            }

        })
    } else{
        $.ajax({
            method: 'get',
            url: 'php_functions/timeToDB.php',
            data: {
                'add': true,
                'time': timeString

            },

            success: function(data) {
                window.alert("Du hast dich eingestempelt");
                location.reload();

            }

        })
    }

}

function arbeitszeit_speichern() {

    window.alert("Test");


    var home1_traveltime = document.getElementById("home1_traveltime").value;

    var date = document.getElementById("date_ess").value;
    var home1_starttime = document.getElementById("home1_starttime").value;

    var work_starttime = document.getElementById("work_starttime").value;
    var work_endtime = document.getElementById("work_endtime").value;
    var work_traveltime = document.getElementById("work_traveltime").value;
    var home2_end = document.getElementById("home2_end").value;

    var ess_startkm = document.getElementById("ess_startkm").value;
    var ess_endkm = document.getElementById("ess_endkm").value;
    var ess_kontakte = document.getElementById("ess_kontakt").value;
    var ess_orte = document.getElementById("ess_orte").value;
    var ess_taten = document.getElementById("ess_taten").value;


    $.ajax({
        method: 'get',
        url: 'php_functions/arbeitszeit_speichern.php',
        data: {
            'add': true,
            'date': date,
            'home1_starttime': home1_starttime,
            'home1_traveltime': home1_traveltime,
            'work_starttime': work_starttime,
            'work_endtime': work_endtime,
            'work_traveltime': work_traveltime,
            'home2_end': home2_end,
            'ess_startkm': ess_startkm,
            'ess_endkm': ess_endkm,
            'ess_kontakte': ess_kontakte,
            'ess_orte': ess_orte,
            'ess_taten': ess_taten


        },

        success: function(data) {
            window.alert(data)


        }

    })
}

function ess_date_change() {
    var date = document.getElementById("date_ess").value;

    $.ajax({
        method: 'get',
        url: 'php_functions/ess_date_change.php',
        data: {
            'add': true,
            'date': date,

        },

        success: function(data) {
            if(data.valueOf() == "No entry"){

            }else {


                var str = String(data);
                var rows = str.split("$");
                document.getElementById("home1_starttime").value = rows[0];
                document.getElementById("home1_traveltime").value = rows[1];
                document.getElementById("work_starttime").value = rows[2];
                document.getElementById("work_endtime").value = rows[3];
                document.getElementById("work_traveltime").value = rows[4];
                document.getElementById("home2_end").value = rows[5];
                document.getElementById("ess_startkm").value = rows[6];
                document.getElementById("ess_endkm").value = rows[7];
                document.getElementById("ess_kontakt").value = rows[8];
                document.getElementById("ess_orte").value = rows[9];
                document.getElementById("ess_taten").value = rows[10];
                //start(column[rows.length-1]);

                if(rows[0]== ""){

                    if(checkBigger(rows[1], rows[2])){
                        var start_anw = rows[2];
                    } else{
                        var start_anw = time_diff(checkDif(time_diff(rows[1], rows[2])), rows[2]);
                    }

                    var end_anw = time_add(checkDif(time_diff(rows[3], rows[4])), rows[3]);

                    document.getElementById("ess_tbl_home1").style.display = "none";

                    document.getElementById("ess_anw").innerText = (start_anw + " - " + end_anw);





                    document.getElementById("ess_anw_calc").innerText = converter(time_diff(start_anw, end_anw));


                    if(rows[5]== ""){

                        document.getElementById("ess_calc").innerText = converter(time_diff("00:30",time_diff(start_anw, end_anw))) + " (ohne 30min Pause)";
                    }else{
                        var adder = time_diff(rows[2], end_anw);
                        document.getElementById("ess_calc").innerText = converter(time_diff("00:30",time_add(adder, time_diff(rows[4], rows[5])))) + " (ohne 30min Pause)";
                    }



                    document.getElementById("ess_reis_time").innerText = (rows[1] + " - " + rows[4]);
                    document.getElementById("ess_reis_km").innerText = (parseInt(rows[7]) - parseInt(rows[6]) + "km");
                    document.getElementById("ess_reis_orte").innerText = (rows[9]);
                } else{
                    document.getElementById("ess_tbl_home1").style.display = "table-row";
                    var start_anw = time_diff(checkDif(time_diff(rows[1], rows[2])), rows[2]);
                    var end_anw = time_add(checkDif(time_diff(rows[3], rows[4])), rows[3]);

                    document.getElementById("ess_home1").innerText = (rows[0] + " - " + rows[1]);

                    document.getElementById("ess_anw").innerText = (start_anw + " - " + end_anw);


                    document.getElementById("ess_home1_calc").innerText = converter(time_diff(rows[0], rows[1]));

                    document.getElementById("ess_anw_calc").innerText = converter(time_diff(start_anw, end_anw));


                    if(rows[5]== ""){

                        document.getElementById("ess_calc").innerText = converter(time_diff("00:30",time_add(time_diff(rows[0], rows[1]), time_diff(start_anw, end_anw)))) + " (ohne 30min Pause)";
                    }else{
                        var adder = time_add(time_diff(rows[0], rows[1]), time_diff(start_anw, end_anw));
                        document.getElementById("ess_calc").innerText = converter(time_diff("00:30",time_add(adder, time_diff(rows[4], rows[5])))) + " (ohne 30min Pause)";
                    }




                    document.getElementById("ess_reis_time").innerText = (rows[1] + " - " + rows[4]);
                    document.getElementById("ess_reis_km").innerText = (parseInt(rows[7]) - parseInt(rows[6]) + "km");
                    document.getElementById("ess_reis_orte").innerText = (rows[9]);
                }

                if(rows[5]== ""){
                    document.getElementById("ess_tbl_home2").style.display = "none";
                } else{
                    document.getElementById("ess_tbl_home2").style.display = "table-row";
                    document.getElementById("ess_home2").innerText = (rows[4] + " - " + rows[5]);
                    document.getElementById("ess_home2_calc").innerText = converter(time_diff(rows[4], rows[5]));
                }

            }
        }


    })
}

function time_diff(start, end) {
    start = start.split(":");
    end = end.split(":");
    var startDate = new Date(0, 0, 0, start[0], start[1], 0);
    var endDate = new Date(0, 0, 0, end[0], end[1], 0);
    var diff = endDate.getTime() - startDate.getTime();
    var hours = Math.floor(diff / 1000 / 60 / 60);
    diff -= hours * 1000 * 60 * 60;
    var minutes = Math.floor(diff / 1000 / 60);

    // If using time pickers with 24 hours format, add the below line get exact hours
    if (hours < 0)
        hours = hours + 24;

    return (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
}

function checkDif(entry) {
    diff = entry.split(":");
    var hours = parseInt(diff[0]) * 60;
    var minutes = parseInt(diff[1]);
    var difference = hours + minutes;
    var result;
    if(difference > parseInt(document.getElementById("ess_default_waytime").value)){
        result = difference - parseInt(document.getElementById("ess_default_waytime").value);
    } else{
        result = 0;
    }
    var m = result % 60;

    var h = (result-m)/60;

    var converted = h.toString() + ":" + (m<10?"0":"") + m.toString();
    return converted;
}

function time_add(start, end) {
    start = start.split(":");
    end = end.split(":");
    var hours = parseInt(start[0]) + parseInt(end[0]);
    var minutes = parseInt(start[1]) + parseInt(end[1]);
    var add_to_hours = Math.floor(minutes/60);
    hours = hours + add_to_hours;
    minutes = minutes%60;
    return (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
}



function converter(time) {
    time = time.split(":");
    return time[0] + "h " + time[1] + "m";
}

function checkBigger(start, end) {
    start = start.split(":");
    end = end.split(":");

    if(parseInt(end[0])> parseInt(start[0])){
        return true;
    }else if(parseInt(end[0])> parseInt(start[0])){
        return false;
    }else{
        if(parseInt(end[1])>= parseInt(start[1])){
            return true;
        }else{
            return false;
        }
    }
}

function generateContactDo() {
    $.ajax({
        method: 'get',
        url: 'php_functions/generateContactDo.php',
        data: {
            'add': true,

        },

        success: function(data) {
            window.alert(data)


        }

    })
}

function ISO8601_week_no(dt)
{
    var tdt = new Date(dt.valueOf());
    var dayn = (dt.getDay() + 6) % 7;
    tdt.setDate(tdt.getDate() - dayn + 3);
    var firstThursday = tdt.valueOf();
    tdt.setMonth(0, 1);
    if (tdt.getDay() !== 4)
    {
        tdt.setMonth(0, 1 + ((4 - tdt.getDay()) + 7) % 7);
    }
    return 1 + Math.ceil((firstThursday - tdt) / 604800000);
}

function showDatenKlauen() {

    if (document.getElementById("apple-switcher3").checked == true) {
        document.getElementById("klauenDiv").style.display = 'block';
        showKlaubar();


    } else {
        document.getElementById("klauenDiv").style.display = 'none';
    }
}
function showKlaubar(){
    $.ajax({
        method: 'get',
        url: 'php_functions/getKlaubar.php',
        data: {
            'add': true,


        },

        success: function(data) {
            var months = data.toString().split(",");
            months.forEach(function (item, index) {
                var option = document.createElement("option");
                option.text = item;
                document.getElementById("klauUser").add(option);
            })


        }

    })
}

function klauenSubmit(){
    var targetType = document.getElementById('klauArt').value;
    var user = document.getElementById('klauUser').value;
    var week = document.getElementById('selectWeek').value;
    var year = document.getElementById('yearNote').value;

    $.ajax({
        method: 'get',
        url: 'php_functions/klauenSubmit.php',
        data: {
            'add': true,
            'type': targetType,
            'user': user,
            'week': week,
            'year': year,
        },

        success: function(data) {
            window.alert(data);
        }

    })
}

