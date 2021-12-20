<?php
    if (isset($_POST["gesendet"])) {
        // Basis URL zum Root Verzeichnis
        $baseUrl = $_SERVER['DOCUMENT_ROOT'];

        // Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
        require $baseUrl . '/content/dbconnect.php';

        // Holt sich die übermittelten Attribute aus dem POST-Request
        $antwort = $_POST["antwort"];
        $uid = $_POST["uid"];

        // Der SQL-Code zum aktualisieren der Antwort-Daten in der DB
        $sql = "UPDATE antworten SET stimmen = (stimmen +1) WHERE a_id = {$antwort};";

        // Wenn SQL-Query erfolgreich, dann Erfolg und Weiterleitung auf Ergebnisse
        // Sonst Misserfolg und Weiterleitung zurück auf Umfrage-Details
        if (mysqli_query($con, $sql)) {
            echo "<h3 class='gesendet-nachricht'>";
            echo "Antwort erfolgreich gesendet.";
            echo "</h3>";
            echo "<div class='loader'></div>";
            header( "refresh:1.5;url=/umfrage-ergebnisse.page.php?uid=".$uid );
        } else {
            echo "<h3 class='gesendet-nachricht'>";
            echo "Es ist ein Fehler aufgetreten, bitte versuche es nochmal! ";
            echo "</h3>";
            echo "<div class='loader'></div>";
            header( "refresh:1.5;url=/umfrage-details.page.php?uid=".$uid );
        }

        // Schließt die offene Datenbankverbindung wieder
        mysqli_close($con);
    }
?>