<div class="table-wrapper">

    <table class="table m-top-30">
        <?php
            // Basis URL zum Root Verzeichnis
            $baseUrl = $_SERVER['DOCUMENT_ROOT'];

            // Lädt eine separate Datei um eine Verbindung mit der DB herzustellen
            require $baseUrl.'/content/dbconnect.php';

            // Ruft Funktion auf mit MySql Query um alle aktiven Umfragen und die abgegebenen Stimmen zu laden
            // Die Funktion nimmt die MySql-Verbindung und eine Bedingung zum Filtern der Daten entgegen
            $active = getMySqlData($con, "BETWEEN umfragen.startdatum 
                                          AND DATE_ADD(umfragen.enddatum, INTERVAL 1 DAY)");
            // Ruft Funktion auf mit MySql Query um alle aktiven Umfragen und die abgegebenen Stimmen zu laden
            $inactive = getMySqlData($con, "NOT BETWEEN umfragen.startdatum 
                                            AND DATE_ADD(umfragen.enddatum, INTERVAL 1 DAY)");

            // Zählt die Anzahl aller Datensätze der Tabelle mithilfe der Reihen-Nummer
            $num = mysqli_num_rows($active) + mysqli_num_rows($inactive);

            // Überprüft, ob die Datensätze größer 0 sind und gibt andernfalls eine entsprechende Meldung aus
            if ($num > 0) {
                    echo "<th>Umfragename</th>";
                    echo "<th>Abgegebene Stimmen</th>";

                    // Funktion mit einer While-Schleife, die die Datensätze durchläuft und die angegebenen Daten ausgibt
                    // Die Funktion nimmt Datensätze und eine CSS-Classe als String entgegen
                    getTableData($active, "active");
                    getTableData($inactive, "inactive");

                } else {
                    echo "<h3>Keine aktiven Umfragen vorhanden.</h3>";
                }

            // Die Funktion enthält den MySql Query-Aufruf zum Selektieren, Filtern und Gruppieren der benötigten Daten
            function getMySqlData($con, $condition) {
                return mysqli_query($con, "SELECT umfragen.name AS 'name', SUM(antworten.stimmen) AS 'stimmen'
                                    FROM `umfragen`
                                    LEFT JOIN `antworten`
                                    ON umfragen.u_id = antworten.umfrage_id
                                    WHERE CURRENT_DATE 
                                    $condition
                                    GROUP BY name;");
            }

            // Die Funktion durchläuft einen Datensatz und baut daraus die entsprechenden Tabellen-Reihen
            // Das Class-Attribut ist ein String, der als Klassen-Name dem Umfrage-Namen angehängt wird
            function getTableData($data, $class) {
                while ($dsatz = mysqli_fetch_assoc($data))
                {
                    echo "<tr>";
                    echo "<td class='$class'>" . $dsatz["name"] . "</td>";

                    // Überprüft ob für die Umfrage Antworten existieren, also die Gesamtanzahl an abgegebenen Stimmen angezeigt werden kann
                    if (isset($dsatz["stimmen"])) {
                        echo "<td>" . $dsatz["stimmen"] . "</td>";
                    } else {
                        echo "<td>keine Antworten gesetzt</td>";
                    }

                    echo "</tr>";
                }
            }

            mysqli_close($con);
        ?>
    </table>

</div>