<?php
require_once 'functions.php';
$conn = connectToDB();
$filialen = [];
        
// SQL-Statement
$query = "SELECT * FROM filiale";

// SQL Statement an die Datenbank senden und Ergebnis in $result speichern
$result = mysqli_query($conn, $query);

// Überprüfung ob die DB-Anfrage (SQL) erfolgreich war
if ($result) {
// Durchlaufen aller Zeilen im Ergebnis
    while ($row = mysqli_fetch_assoc($result)) {
         $filialen[] = $row;
    }
}

if (isPostRequest()){
    $formData = [
        'vorname' => formFieldValue('vorname', ''),
        'nachname' => formFieldValue('nachname', ''),
        'geburtsdatum' => formFieldValue('geburtsdatum', null, false),
        'telefon' => formFieldValue('telefon', ''),
        'geburtsort' => formFieldValue('geburtsort', ''),
        'selectForm' => formFieldValue('selectForm', ''), 
    ];
    $formData['geburtsdatum'] = str_replace("-", "",  $formData['geburtsdatum']);
    echo "<script>console.log('" . json_encode($formData) . "');</script>";

    $query = "INSERT INTO kunde (vorname, nachname, geburtsdatum, telefon, geburtsort, filialeId)"
                ." VALUES ('" . $formData['vorname'] . "', '" . $formData['nachname'] . "', " . $formData['geburtsdatum'] . ", '" . $formData['telefon'] . "', '" . $formData['geburtsort'] . "', " . $formData['selectForm'] . ")";
        
                echo "'<script>console.log(\"$query\")</script>'";
        // Wenn das Insert erfolgreich war
        if (mysqli_query($conn, $query)) {
            // DB Verbindung schließen
            closeDB($conn);
            
            // Weiterleitung auf die index.php
            header('Location: index.php');
        } else {
            $errorMessages['general'] = 'Beim Einfügen in die Datenbank ist ein Fehler aufgetreten';
        }
    
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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <h1>Kunde hinzufügen</h1>
        <form action="customer_add.php" method="POST">
            <div class="mb-3">
                <label for="vorname" class="form-label">Vorname</label>
                <input type="text" class="form-control" name="vorname" id="vorname">
            </div>
            <div class="mb-3">
                <label for="nachname" class="form-label">Nachname</label>
                <input type="text" class="form-control" name="nachname" id="nachname">
            </div>
            <div class="mb-3">
                <label for="geburtsdatum" class="form-label">Geburtsdatum</label>
                <input type="date" class="form-control" name="geburtsdatum" id="geburtsdatum">
            </div>
            <div class="mb-3">
                <label for="telefon" class="form-label">Telefonsnummer</label>
                <input type="text" class="form-control" name="telefon" id="telefon">
            </div>
            <div class="mb-3">
                <label for="geburtsort" class="form-label">Geburtsort</label>
                <input type="text" class="form-control" name="geburtsort" id="geburtsort">
            </div>
            <div class="mb-3">
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="selectForm" id="selectForm">
                    <?php foreach ($filialen as $filiale): ?>
                        <option value="<?= $filiale['filialeId'] ?>"><?= $filiale['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Hinzufügen</button>
            <button class="btn btn-primary" type="button" onclick="location.href='index.php';">Abbrechen</button>
        </form>
    </body>
</html>