<?php
// Basis URL zum Root Verzeichnis
$baseUrl = $_SERVER['DOCUMENT_ROOT'];

// Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
require $baseUrl . '/content/dbconnect.php';

// Wenn Antwort erstellt
if (isset($_POST["create"])) {

    // Holt sich die übermittelten Attribute aus dem POST-Request
    $inhalt = $_POST["inhalt"];
    $uid = $_POST["uid"];

    $sql = "INSERT INTO antworten (umfrage_id, inhalt) VALUE ('$uid', '$inhalt')";

    // Wenn Query (nicht) erfolgreich, kurze Info und Weiterleitung auf Übersicht
    if (mysqli_query($con, $sql)) {
        echo "<h3 class='gesendet-nachricht'>";
        echo "Antwort erfolgreich erstellt.";
        echo "</h3>";
        echo "<div class='loader'></div>";
        header( "refresh:1.5;url=/backend/uebersicht.page.php" );
    } else {
        echo "<h3 class='gesendet-nachricht'>";
        echo "Es ist ein Fehler aufgetreten, bitte versuche es nochmal! ";
        echo "</h3>";
        echo "<div class='loader'></div>";
        header( "refresh:1.5;url=/backend/uebersicht.page.php" );
    }
}

// Wenn Antwort bearbeitet
if (isset($_POST["edit"])) {

    // Holt sich die übermittelten Attribute aus dem POST-Request
    $uid = $_POST["uid"];

    $isSuccessful = true;
    // Für jedes Attribut aus dem POST, das nicht "uid" und "edit" entspricht, wird die betroffene Antwort in der DB geändert
    // Um welche Antwort es geht, verrät der Name des Attributs, der der jeweiligen Antwort-ID entspricht
    foreach ($_POST as $param_name => $param_val) {
        if ($param_name !== "uid" && $param_name !== "edit") {
            $sql = "UPDATE antworten SET umfrage_id = '$uid', inhalt = '$param_val' WHERE a_id = {$param_name};";

            if (!mysqli_query($con, $sql)) {
                $isSuccessful = false;
            }
        }
    }

    // Wenn Query (nicht) erfolgreich, kurze Info und Weiterleitung auf Übersicht
    if ($isSuccessful) {
        echo "<h3 class='gesendet-nachricht'>";
        echo "Antwort erfolgreich bearbeitet.";
        echo "</h3>";
        echo "<div class='loader'></div>";
        header( "refresh:1.5;url=/backend/uebersicht.page.php" );
    } else {
        echo "<h3 class='gesendet-nachricht'>";
        echo "Es ist ein Fehler aufgetreten, bitte versuche es nochmal! ";
        echo "</h3>";
        echo "<div class='loader'></div>";
        header( "refresh:1.5;url=/backend/uebersicht.page.php" );
    }
}

//Wenn Antwort gelöscht
if (isset($_POST["delete"])) {

    // Holt sich die übermittelten Attribute aus dem POST-Request
    $aid = $_POST["aid"];


    // Der SQL-Code zum Löschen einer Antwort in der DB
    $sql = "DELETE FROM antworten WHERE a_id = {$aid};";

    // Wenn Query (nicht) erfolgreich, kurze Info und Weiterleitung auf Übersicht
    if (mysqli_query($con, $sql)) {
        echo "<h3 class='gesendet-nachricht'>";
        echo "Antwort erfolgreich entfernt.";
        echo "</h3>";
        echo "<div class='loader'></div>";
        header( "refresh:1.5;url=/backend/uebersicht.page.php" );
    } else {
        echo "<h3 class='gesendet-nachricht'>";
        echo "Es ist ein Fehler aufgetreten, bitte versuche es nochmal! ";
        echo "</h3>";
        echo "<div class='loader'></div>";
        header( "refresh:1.5;url=/backend/uebersicht.page.php" );
    }
}

// Schließt die offene Datenbankverbindung wieder
mysqli_close($con);
?>