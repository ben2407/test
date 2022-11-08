<?php
require_once 'config.php';
require_once 'functions.php';

// DB-Verbindung
connectToDB($conn);
echo var_dump($conn) . '<br><br>';

// SQL Statement
$query = "SELECT autos.*, marken.markenname as marke, baujahre.baujahr as baujahr FROM autos "
. " JOIN marken ON marke.marke_id = autos.marke_id "
. " JOIN baujahre ON baujahre.baujahr_id = autos.baujahr_id ";

// Überprüfen ob ein GetRequest gesendet wurde
if (isGetRequest()) {
    // Übergebene Daten aus GET-Request auslesen und in Array speichern
    $formData = [
        'antriebsartid' => formFieldValueGet('antriebsart_id', ''),
        'markeid' => formFieldValueGet('marke_id', ''),        
    ];
    if ($formData['antriebsart_id'] == '' && $formData['markeid'] == '') {
        $query = $query . " ORDER BY autos.aktualisierungszeitpunkt DESC";
        $stmt = $conn->prepare($query);
    } elseif (!$formData['antriebsart_id'] == '' && $formData['markeid'] == ''){
        $query = $query . " WHERE autos.antriebsart_id = ?" . " ORDER BY autos.aktualisierungszeitpunkt DESC ";
        echo var_dump($query) . '<br><br>';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $formData['antriebsartid']);
    }     elseif ($formData['antriebsart_id'] == '' && !$formData['markeid'] == ''){
        $query = $query . " WHERE autos.marke_id = ?" . " ORDER BY autos.aktualisierungszeitpunkt DESC ";
        echo var_dump($query) . '<br><br>';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $formData['markeid']);
    } else {
        $query = $query . " WHERE autos.antriebsart_id = ? " . " WHERE autos.marke_id = ? " . " ORDER BY autos.aktualisierungszeitpunkt DESC ";
        echo var_dump($query) . '<br><br>';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $formData['antriebsartid'], $formData['markeid']);

    }
}

// Statement ausführen
$stmt->execute();

// Ergebnis des Statements in resultat speichern
$result = $stmt->get_result();

// leeren Array erzeugen
$autos = [];

// Anzahl der Reihen im Resultat überprüfen
if ($result && $result->num_rows > 0) {
    // Durchlaufen aller Datensätze und auslesen eines Datensatzes als assoziativen Arrays
    while ($row = $result->fetch_object()) {
        $autos[] = $row;
    }
}

echo var_dump($autos) . '<br><br>';





closeDB($conn);
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Verfügbare Gebrauchtwagen</title>
    </head>
    <body>
        <h1>Verfügbare Gebrauchtwagen</h1>
        
        <div> 
            <form action="index.php" method="GET">
               <label>Nach Antriebsart</label>
                <select name="antriebsartid" id="antriebsartid">
                    <option value="" selected>Alle</option>
                    <?php foreach ($autos as $auto): ?>
                        <option value="<?php echo array_unique($auto->antriebsart_id) ?>"><?php echo $auto->antriebsart ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Marke</label>
                <select name="markeid" id="markeid">
                    <option value="" selected>Alle</option>
                    <?php foreach ($autos as $auto): ?>
                        <option value="<?php echo array_unique($auto->marke_id) ?>"><?php echo $auto->marke ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">filtern</button>
            </form>
        </div>



<?php if ($autos && $autos->num_rows > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modell</th>
                    <th>Marke</th>
                    <th>Antriebsart</th>
                    <th>Baujahr</th>
                    <th>Preis</th>
                    <th><?php '&nsbp;'?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($autos as $auto): ?>
                    <tr>
                        <td><?php echo $auto->auto_id ?></td>
                        <td><?php echo $auto->modelbezeichnung ?></td>
                        <td><?php echo $auto->marke ?></td>
                        <td><?php echo $auto->antriebsart ?></td>
                        <td><?php echo $auto->baujahr ?></td>
                        <td><?php echo $auto->preis ?></td>                        
                        <td><a href="auto_details.php?id=<?php echo $auto->auto_id ?>">Details</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else echo 'Keine Autos gefunden!' : ?>
            <br>
    <nav><a href="index.php">Zurück zur Übersicht</a></nav>  
        <?php endif; ?>       
    </body>
</html>
