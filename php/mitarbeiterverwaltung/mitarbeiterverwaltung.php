<?php
$conn = mysqli_connect('localhost', 'root', '', 'mitarbeiterverwaltung');
$records = [];
$radio = '';
// Laden des Autors aus der Datenbank
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    //echo '<script>console.log("post")</script>';
    $mitarbeiter = [];
        $query = "SELECT * FROM mitarbeiterverwaltung.mitarbeiterverwaltung";
        $result = mysqli_query($conn, $query);

        if ($result) {
        // Durchlaufen aller Zeilen im Ergebnis
            while ($row = mysqli_fetch_assoc($result)) {
            $mitarbeiter[] = $row;
        }
    }
    $radio = $_POST['radio'];
    //echo "'<script>console.log(\"$radio\")</script>'";
    if ($radio === "vorigermonat") {
        $records = array_filter($mitarbeiter, function ($row) {
            $date = $row['geburtsdatum'];
            $month = date('m') - 1;
            $date = date("m",strtotime($date));
            //echo "'<script>console.log(\"$month\")</script>'";
            return $date == $month;
        });

        echo "<script>console.log('" . json_encode($records) . "');</script>";
    }
    else if ($radio === "aktuellermonat") {
        $records = array_filter($mitarbeiter, function ($row) {
            $date = $row['geburtsdatum'];
            $month = date('m');
            $date = date("m",strtotime($date));
            //echo "'<script>console.log(\"$month\")</script>'";
            return $date == $month;
        });

        echo "<script>console.log('" . json_encode($records) . "');</script>";
    }
    else if ($radio === "naechstermonat") {
        $records = array_filter($mitarbeiter, function ($row) {
            $date = $row['geburtsdatum'];
            $month = date('m');
            if ($month === 12) {
                $month = 1;
            }
            else {
                $month = $month + 1;
            }
            $date = date("m",strtotime($date));
            //echo "'<script>console.log(\"$month\")</script>'";
            return $date == $month;
        });

        echo "<script>console.log('" . json_encode($records) . "');</script>";
    }
}

?>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mitarbeiterverwaltung</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
        <h2 >Mitarbeiterverwaltung</h2>
        <div class="row" style="width:100%;">
        <div class="col-3" >
        <form actio="mitarbeiterverwaltung.php" method="POST">
            <fieldset class="mb-3">
                <legend>Welcher Monat</legend>
                <div class="form-check">
                    <input type="radio" name="radio" class="form-check-input" id="vorigermonat" value="vorigermonat" <?php echo ($radio == 'vorigermonat') ?  "checked" : "" ;  ?>>
                    <label class="form-check-label" for="vorigermonat">Voriger Monat</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="radio" name="radio" class="form-check-input" id="aktuellermonat" value="aktuellermonat" <?php echo ($radio == 'aktuellermonat') ?  "checked" : "" ;  ?>>
                    <label class="form-check-label" for="aktuellermonat">aktueller Monat</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="radio" name="radio" class="form-check-input" id="naechstermonat" value="naechstermonat" <?php echo ($radio == 'naechstermonat') ?  "checked" : "" ;  ?>>
                    <label class="form-check-label" for="naechstermonat">Nächster Monat</label>
                </div>
            </fieldset>
            <button type="submit">Choose</button>
        </form>
</div>
<div class="col-4"></div>
<div class="col-5"></div>
</div>

        <?php if (count($records) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr class="table-primary">
                        <th>ID</th>
                        <th>Titel</th>
                        <th>Geschlecht</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>Geburtstag</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?= $record['mitarbeiterId'] ?></td>
                            <td><?= $record['titel'] ?></td>
                            <td><?= $record['geschlecht'] ?></td>
                            <td><?= $record['vorname'] ?></td>
                            <td><?= $record['nachname'] ?></td>
                            <td><?= date("d-m-Y", strtotime($record['geburtsdatum'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </body>
</html>