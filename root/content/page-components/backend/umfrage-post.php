<?php
    // Basis URL zum Root Verzeichnis
    $baseUrl = $_SERVER['DOCUMENT_ROOT'];

    // Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
    require $baseUrl . '/content/dbconnect.php';

    // Wenn Umfrage erstellt
    if (isset($_POST["create"])) {

        // Holt sich die übermittelten Attribute aus dem POST-Request
        $name = $_POST["name"];
        $beschreibung = $_POST["beschreibung"];
        $kid = $_POST["kid"];
        $start = $_POST["start"];
        $end = $_POST["end"];

        // SQL-Statement zum Erstellen der neuen Umfrage
        $sql = "INSERT INTO umfragen (name, beschreibung, kategorie_id, startdatum, enddatum) 
                VALUE ('$name', '$beschreibung', '$kid', '$start', '$end')";

        // Wenn Query (nicht) erfolgreich, kurze Info und Weiterleitung auf Übersicht
        if (mysqli_query($con, $sql)) {
            echo "<h3 class='gesendet-nachricht'>";
            echo "Umfrage erfolgreich erstellt.";
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

    // Wenn Umfrage bearbeitet
    if (isset($_POST["edit"])) {

        // Holt sich die übermittelten Attribute aus dem POST-Request
        $name = $_POST["name"];
        $beschreibung = $_POST["beschreibung"];
        $start = $_POST["start"];
        $end = $_POST["end"];
        $uid = $_POST["uid"];
        $kid = $_POST["kid"];

        // Der SQL-Code zum Bearbeiten einer Umfrage in der DB
        $sql = "UPDATE umfragen SET name = '$name', beschreibung = '$beschreibung', kategorie_id = '$kid', 
                    startdatum = '$start', enddatum = '$end' WHERE u_id = {$uid};";

        // Wenn Query (nicht) erfolgreich, kurze Info und Weiterleitung auf Übersicht
        if (mysqli_query($con, $sql)) {
            echo "<h3 class='gesendet-nachricht'>";
            echo "Umfrage erfolgreich bearbeitet.";
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

    //Wenn Umfrage gelöscht
    if (isset($_POST["delete"])) {

        // Holt sich die übermittelten Attribute aus dem POST-Request
        $uid = $_POST["uid"];


        // Der SQL-Code zum Löschen einer Umfrage in der DB
        $sql = "DELETE FROM umfragen WHERE u_id = {$uid};";

        // Wenn Query (nicht) erfolgreich, kurze Info und Weiterleitung auf Übersicht
        if (mysqli_query($con, $sql)) {
            echo "<h3 class='gesendet-nachricht'>";
            echo "Umfrage erfolgreich entfernt.";
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