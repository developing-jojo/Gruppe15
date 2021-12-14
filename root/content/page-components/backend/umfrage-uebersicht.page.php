<div class="table-wrapper">

    <table class="table m-top-30">
        <?php
            // Basis URL zum Root Verzeichnis
            $baseUrl = $_SERVER['DOCUMENT_ROOT'];

            // Lädt eine separate Datei um eine Verbindung mit der DB herzustellen
            require $baseUrl.'/content/dbconnect.php';

            // Ruft Funktion auf mit MySql Query um alle aktiven Umfragen und die abgegebenen Stimmen zu laden
            // Die Funktion nimmt die MySql-Verbindung und eine Bedingung zum Filtern der Daten entgegen
            $umfragenRes = mysqli_query($con, "SELECT umfragen.*, SUM(antworten.stimmen) AS 'stimmen'
                                                FROM `umfragen`
                                                LEFT JOIN `antworten`
                                                ON umfragen.u_id = antworten.umfrage_id
                                                GROUP BY umfragen.u_id
                                                ORDER BY stimmen DESC ");


            // Zählt die Anzahl aller Datensätze der Tabelle mithilfe der Reihen-Nummer
            $num = mysqli_num_rows($umfragenRes);

            // Überprüft, ob die Datensätze größer 0 sind und gibt andernfalls eine entsprechende Meldung aus
            if ($num > 0) {
                echo "<th>Umfragename</th>";
                echo "<th>Abgegebene Stimmen</th>";

                $umfragenRes -> data_seek(0);
                $highestRow = mysqli_fetch_row($umfragenRes)[0];

                $umfragenRes -> data_seek(0);
                $value = mysqli_fetch_row($umfragenRes)[6];

                $lowestRow = 0;

                $umfragenRes -> data_seek(0);
                while($dsatz = mysqli_fetch_assoc($umfragenRes)) {
                    $stimmen = $dsatz["stimmen"];
                    $uid = $dsatz["u_id"];

                    if($value >= $stimmen && $stimmen > 0) {
                        $lowestRow = $uid;
                        $value = $stimmen;
                    }
                }

                // Setzt den Zähler für den Datensatz auf Zeile 0 zurück
                $umfragenRes -> data_seek(0);

                // Die Schleife durchläuft einen Datensatz und baut daraus die entsprechenden Tabellen-Reihen
                // Das Class-Attribut ist ein String, der als Klassen-Name dem Umfrage-Namen angehängt wird
                while ($dsatz = mysqli_fetch_assoc($umfragenRes))
                {
                    echo "<tr>";

                    getActiveInactive($dsatz);

                    // Überprüft ob für die Umfrage Antworten existieren, also die Gesamtanzahl an abgegebenen Stimmen angezeigt werden kann
                    if (isset($dsatz["stimmen"])) {

                        if($dsatz["u_id"] === $highestRow) {
                            echo "<td>" . $dsatz["stimmen"] . " (höchster Wert)</td>";
                        } elseif($dsatz["u_id"] === $lowestRow) {
                            echo "<td>" . $dsatz["stimmen"] . " (niedrigster Wert)</td>";
                        } else {
                            echo "<td>" . $dsatz["stimmen"] . "</td>";
                        }
                    } else {
                        echo "<td value='0'>keine Antworten gesetzt</td>";
                    }

                    echo "</tr>";
                }


            } else {
                echo "<h3>Keine aktiven Umfragen vorhanden.</h3>";
            }


            function getActiveInactive($dsatz) {
                $currentDate = date('Ymd', time());
                $start = $dsatz["startdatum"];
                $end = $dsatz["enddatum"];

                $start = date_create_from_format("Y-m-d", $start);
                $end = date_create_from_format("Y-m-d", $end);

                $start = date_format($start, "Ymd");
                $end = date_format($end, "Ymd");

                if ($currentDate >= $start && $currentDate <= $end ) {
                    echo "<td class='active'>" . $dsatz["name"] . "</td>";
                } else {
                    echo "<td class='inactive'>" . $dsatz["name"] . "</td>";
                }
            }

            // Schließt die offene Datenbankverbindung wieder
            mysqli_close($con);
        ?>
    </table>

</div>