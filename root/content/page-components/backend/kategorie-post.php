<?php
    // Basis URL zum Root Verzeichnis
    $baseUrl = $_SERVER['DOCUMENT_ROOT'];

    // Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
    require $baseUrl . '/content/dbconnect.php';

    // Wenn Kategorie erstellt
    if (isset($_POST["create"])) {

        // Holt sich die übermittelten Attribute aus dem POST-Request
        $bezeichnung = $_POST["bezeichnung"];

        // Der SQL-Code zum Erstellen einer Kategorie in der DB
        $sql = "INSERT INTO kategorien (bezeichnung) VALUE ('$bezeichnung')";

        // Wenn SQL-Query erfolgreich, dann Erfolg und Weiterleitung auf Ergebnisse
        // Sonst Misserfolg und Weiterleitung zurück auf Übersicht
        if (mysqli_query($con, $sql)) {
            echo "<h3 class='gesendet-nachricht'>";
            echo "Kategorie erfolgreich erstellt.";
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

        // Schließt die offene Datenbankverbindung wieder
        mysqli_close($con);
    }

    // Wenn Kategorie bearbeitet
    if (isset($_POST["edit"])) {

        // Holt sich die übermittelten Attribute aus dem POST-Request
        $bezeichnung = $_POST["bezeichnung"];
        $kid = $_POST["kid"];

        // Der SQL-Code zum Bearbeiten einer Kategorie in der DB
        $sql = "UPDATE kategorien SET bezeichnung = '$bezeichnung' WHERE k_id = {$kid};";

        // Wenn SQL-Query erfolgreich, dann Erfolg und Weiterleitung auf Ergebnisse
        // Sonst Misserfolg und Weiterleitung zurück auf Übersicht
        if (mysqli_query($con, $sql)) {
            echo "<h3 class='gesendet-nachricht'>";
            echo "Kategorie erfolgreich bearbeitet.";
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

    //Wenn Kategorie gelöscht
    if (isset($_POST["delete"])) {

        // Holt sich die übermittelten Attribute aus dem POST-Request
        $kid = $_POST["kid"];

        // Der SQL-Code zum Bearbeiten einer Kategorie in der DB
        $sql = "DELETE FROM kategorien WHERE k_id = {$kid};";

        // Wenn SQL-Query erfolgreich, dann Erfolg und Weiterleitung auf Ergebnisse
        // Sonst Misserfolg und Weiterleitung zurück auf Übersicht
        if (mysqli_query($con, $sql)) {
            echo "<h3 class='gesendet-nachricht'>";
            echo "Kategorie erfolgreich entfernt.";
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