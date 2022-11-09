<?php
require_once 'functions.php';
$conn = connectToDB();
$string = "QR Code";
if (isPostRequest()){
    $formData = [
        'anrede' => formFieldValue('anrede', ''),
        'vorname' => formFieldValue('vorname', ''),
        'nachname' => formFieldValue('nachname', ''),
        'anschrift' => formFieldValue('anschrift', ''),
        'plz' => formFieldValue('plz', ''),
        'ort' => formFieldValue('ort', ''),
    ];

    //echo "<script>console.log('" . json_encode($formData) . "');</script>";

    $query = "INSERT INTO kunde (anrede, vorname, nachname, anschrift, plz, ort)"
                ." VALUES ('" . $formData['anrede'] . "', '" . $formData['vorname'] . "', '" . $formData['nachname'] . "', '" . $formData['anschrift'] . "', '" . $formData['plz'] . "', '" . $formData['ort'] . "')";
        
                echo "'<script>console.log(\"$query\")</script>'";
        // Wenn das Insert erfolgreich war
        if (mysqli_query($conn, $query)) {
            // DB Verbindung schließen
            closeDB($conn);
        } else {
            $errorMessages['general'] = 'Beim Einfügen in die Datenbank ist ein Fehler aufgetreten';
        }
        $string = $formData['anrede'] . " " . $formData['vorname'] . " " . $formData['nachname'] . " " . $formData['anschrift'] . " " . $formData['plz'] . " " . $formData['ort'];
    
;
}
?>



<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Kunde hinzufügen</title>
        <script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript" src="qrcode.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
        #qrcode {
            width: 160px;
            height: 160px;
            margin-top: 15px;
        }
        </style>
        <script>
            function qrcodefunc () {
                var qrcode = new QRCode("qrcode");
                function makeCode () {    
                var elText = document.getElementById("text");
                if (!elText.value) {
                    alert("Input a text");
                    elText.focus();
                    return;
                }
  
                qrcode.makeCode(elText.value);
                }

                makeCode();

                $("#text").
                on("blur", function () {
                makeCode();
                }).
                on("keydown", function (e) {
                if (e.keyCode == 13) {
                    makeCode();
                    }
                });
            }
        </script>
    </head>
    <body style="margin-right: 1100px;margin-left: 20px;">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <h1>Kunde hinzufügen</h1>
        <form action="index.php" method="POST">
            <div class="mb-3">
                <label for="anrede" class="form-label">Anrede</label>
                <input type="text" class="form-control" name="anrede" id="anrede">
            </div>
            <div class="mb-3">
                <label for="vorname" class="form-label">Vorname</label>
                <input type="text" class="form-control" name="vorname" id="vorname">
            </div>
            <div class="mb-3">
                <label for="nachname" class="form-label">Nachname</label>
                <input type="text" class="form-control" name="nachname" id="nachname">
            </div>
            <div class="mb-3">
                <label for="anschrift" class="form-label">Anschrift</label>
                <input type="text" class="form-control" name="anschrift" id="anschrift">
            </div>
            <div class="mb-3">
                <label for="plz" class="form-label">PLZ</label>
                <input type="text" class="form-control" name="plz" id="plz">
            </div>
            <div class="mb-3">
                <label for="ort" class="form-label">Ort</label>
                <input type="text" class="form-control" name="ort" id="ort">
            </div>
            <button class="btn btn-primary" type="submit">Hinzufügen und QR Code generieren</button>
        </form>
        <input id="text" type="text" value = "<?php echo $string;?>" style="width:80%" /><br />
        <div id="qrcode"></div>
        <?php echo '<script type="text/javascript">qrcodefunc();</script>'; ?>
    </body>
</html>