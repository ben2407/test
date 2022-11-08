<?php
require_once 'functions.php';
$conn = connectToDB();
$query = "";
$kunden = [];
$filialen = [];
$ausgewaelteFiliale = 0;
$isPostRequest = isPostRequest();
$filialenQuery = "SELECT * FROM filiale";
    $result = mysqli_query($conn, $filialenQuery);

// Überprüfung ob die DB-Anfrage (SQL) erfolgreich war
if ($result) {
// Durchlaufen aller Zeilen im Ergebnis
    while ($row = mysqli_fetch_assoc($result)) {
         $filialen[] = $row;
    }
}
if (isPostRequest()) {
    
    $radio = formFieldValue('radios', '');
if ($radio === "alleFilialen") {
        $query = "SELECT kundeId, vorname, nachname, geburtsdatum, telefon, geburtsort, filiale.name FROM kundenverwaltung.kunde
                JOIN filiale ON kunde.filialeId = filiale.filialeId;";
    }
else if ($radio === "bestimmteFiliale") {
    
    $ausgewaelteFiliale = formFieldValue('selectForm', '');
    //echo "'<script>console.log(\"$ausgewaelteFiliale\")</script>'";
        $query = "SELECT kundeId, vorname, nachname, geburtsdatum, telefon, geburtsort, filiale.name FROM kundenverwaltung.kunde
JOIN filiale ON kunde.filialeId = filiale.filialeId
WHERE filiale.filialeId = $ausgewaelteFiliale;";
}
if (!empty($query)) {
    $result = mysqli_query($conn, $query);
    if ($result) {
     //Durchlaufen aller Zeilen im Ergebnis
    while ($row = mysqli_fetch_assoc($result)) {
        $kunden[] = $row;
    }

}
}


}

    
//$query = "";
//$result = mysqli_query($conn, $query);
//if ($result) {
    // Durchlaufen aller Zeilen im Ergebnis
    //while ($row = mysqli_fetch_assoc($result)) {
        //$databases[] = $row;
    //}
//}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kundenverwaltung</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <h1>Kundenverwaltung</h1>
        <br>
        <a class="btn btn-success" href="customer_add.php">Kunde hinzufügen</a> <br> <br>
        <form actio="index.php" method="POST">
            <fieldset class="mb-3">
                <div class="form-check">
                    <input type="radio" name="radios" class="form-check-input" id="alleFilialen" value="alleFilialen" <?php echo (empty($radio) || $radio == 'alleFilialen') ?  "checked" : "" ;  ?>>
                    <label class="form-check-label" for="alleFilialen">Alle Filialen</label>
                </div>
                    <div class="mb-3 form-check">
                        <input type="radio" name="radios" class="form-check-input" id="bestimmteFiliale" value="bestimmteFiliale" <?php echo (!empty($radio) && $radio == 'bestimmteFiliale') ?  "checked" : "" ;  ?>>
                        <label class="form-check-label" for="bestimmteFiliale">Filiale auswählen</label>
                    </div>
          </fieldset>
          <div class="mb-3">
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="selectForm" id="selectForm">
                    <?php foreach ($filialen as $filiale): ?>
                        <option value="<?= $filiale['filialeId'] ?>" <?php echo ($ausgewaelteFiliale == $filiale['filialeId']) ?  "selected" : "" ;  ?>><?= $filiale['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
          <button type="submit">Choose</button>
    </form>
<?php if (count($kunden) > 0): ?>
    <table class="table table-striped">
          <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Vorname</th>
            <th scope="col">Nachname</th>
            <th scope="col">Geburtsdatum</th>
            <th scope="col">Telefon</th>
            <th scope="col">Geburtsort</th>
            <th scope="col">Filiale</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($kunden as $kunde): ?>
                        <tr>
                            <td><?= $kunde['kundeId'] ?></td>
                            <td><?= $kunde['vorname'] ?></td>
                            <td><?= $kunde['nachname'] ?></td>
                            <td><?= date("d-m-Y", strtotime($kunde['geburtsdatum'])); ?></td>
                            <td><?= $kunde['telefon'] ?></td>
                            <td><?= $kunde['geburtsort'] ?></td>
                            <td><?= $kunde['name'] ?></td>
                        </tr>
                    <?php endforeach; ?>
          </tbody>
        </table>
        <?php endif; ?>
    </body>
</html>