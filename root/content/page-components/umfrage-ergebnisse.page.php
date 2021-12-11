<div class="table-wrapper">

    <table class="table m-top-30">
        <?php
            $uid = $_GET['uid'];
            // Basis URL zum Root Verzeichnis
            $baseUrl = $_SERVER['DOCUMENT_ROOT'];

            // Lädt eine separate Datei um eine Verbindung mit der DB herzustellen
            require $baseUrl.'/content/dbconnect.php';

            // MySql Query lädt die Umfrage, bei der die ID mit der UID aus dem POST-Request übereinstimmt
            $umfrageRes = mysqli_query($con, "SELECT *
                                              FROM `umfragen`
                                              WHERE umfragen.u_id = $uid");
            // MySql Query lädt die Antworten, bei der die Umfrage-ID (FS) mit der UID aus dem POST-Request übereinstimmen
            $antwortenRes = mysqli_query($con, "SELECT * 
                                                FROM `antworten`
                                                WHERE antworten.umfrage_id = $uid");

            // Holt sich den Inhalt aus dem MySql-Query-Result und gibt ihn aus
            $umfrage = mysqli_fetch_assoc($umfrageRes);
            echo "<h1>" . $umfrage['name'] . "</h1>";
            echo "<h3>" . $umfrage['beschreibung'] . "</h3>";

            echo "<th>Antwortmöglichkeit</th>";
            echo "<th>Abgegebene Stimmen</th>";

            // Holt sich in einer Schleife die Inhalte aus dem MySql-Query-Result und gibt sie in einer Tabelle aus
            while ($dsatz = mysqli_fetch_assoc($antwortenRes))
            {
                echo "<tr>";
                echo "<td>" . $dsatz["inhalt"] . "</td>";
                echo "<td>" . $dsatz["stimmen"] . "</td>";
                echo "</tr>";
            }

            // Schließt die offene Datenbankverbindung wieder
            mysqli_close($con);
        ?>
    </table>

</div>