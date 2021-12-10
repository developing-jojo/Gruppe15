<?php
if (isset($_POST["gesendet"])) {
    // Basis URL zum Root Verzeichnis
    $baseUrl = $_SERVER['DOCUMENT_ROOT'];

    // Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
    require $baseUrl . '/content/dbconnect.php';

    $antwort = $_POST["antwort"];
    $uid = $_POST["uid"];
    $sql = "UPDATE antworten SET stimmen = (stimmen +1) WHERE a_id = {$antwort};";

    if (mysqli_query($con, $sql)) {
        echo "<h3 class='gesendet-nachricht'>";
        echo "Antwort erfolgreich gesendet.";
        echo "</h3>";
        echo "<div class='loader'></div>";
        header( "refresh:3;url=/umfrage-ergebnisse.page.php?uid=".$uid );
    } else {
        echo "<h3 class='gesendet-nachricht'>";
        echo "Es ist ein Fehler aufgetreten, bitte versuche es nochmal! ";
        echo "</h3>";
        echo "<div class='loader'></div>";
        header( "refresh:3;url=/umfrage-details.page.php?uid=".$uid );
    }

    mysqli_close($con);
}

?>