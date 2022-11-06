<?php
$conn = mysqli_connect('localhost', 'root', '');
$databases = [];
$query = "SELECT schema_name
FROM information_schema.schemata;";
$result = mysqli_query($conn, $query);
if ($result) {
    // Durchlaufen aller Zeilen im Ergebnis
    while ($row = mysqli_fetch_assoc($result)) {
        $databases[] = $row;
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bücherei</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <h1>Databases</h1>
        <table class="table table-striped">
            <tbody>
                <?php foreach ($databases as $database): ?>
                    <tr>
                        <td><?= $database['schema_name'] ?></td>
                        <td><a class="btn btn-info" href="datenbank_details.php?id=<?= $database['schema_name'] ?>">Auswahl</a></td>
                            
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>