<div class="table-wrapper">

    <table class="table m-top-30">
        <?php
            // Basis URL zum Root Verzeichnis
            $baseUrl = $_SERVER['DOCUMENT_ROOT'];

            // Lädt eine separate Datei um eine Verbindung mit der DB herzustellen
            require $baseUrl.'/content/dbconnect.php';

            // MySql-Query fragt alle existierenden Umfragen + ihre Gesamtanzahl abgegebener Stimmen der Antworten ab
                // und sortiert nach Stimmen (weniger werdend)
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

                // Setzt den Zähler für den Datensatz auf Zeile 0 zurück
                $umfragenRes -> data_seek(0);
                // Speichert die Umfrage-Id der ersten Reihe (dank Sortierung die Reihe mit den meisten Antworten)
                $highestRow = mysqli_fetch_row($umfragenRes)[0];

                $umfragenRes -> data_seek(0);
                // Holt sich die Gesamtanzahl der Stimmen der ersten Reihe um damit den Vergleich für die Reihe mit den
                    // wenigsten abgegebenen Stimmen zu starten
                $value = mysqli_fetch_row($umfragenRes)[6];

                $lowestRow = 0;

                $umfragenRes -> data_seek(0);
                // Solange Datensätze im Array gefunden werden, überprüft die Schleife ob der aktuelle Wert an
                    // abgegebenen Stimmen größer 0 und größer gleich letzter Wert sind um so die wenigsten Stimmen zu
                    // ermitteln - Die Umfrage-Id der ermittelten Reihe wird gespeichert
                while($dsatz = mysqli_fetch_assoc($umfragenRes)) {
                    $stimmen = $dsatz["stimmen"];
                    $uid = $dsatz["u_id"];

                    if($value >= $stimmen && $stimmen > 0) {
                        $lowestRow = $uid;
                        $value = $stimmen;
                    }
                }

                $umfragenRes -> data_seek(0);

                // Die Schleife durchläuft das MySql-Query-Ergebnis und baut daraus die entsprechenden Tabellen-Reihen
                // Das Class-Attribut ist ein String, der als Klassen-Name dem Umfrage-Namen angehängt wird
                while ($dsatz = mysqli_fetch_assoc($umfragenRes))
                {
                    echo "<tr>";

                    // Lädt die aktiven und inaktiven Umfrage(-name)n
                    getActiveInactive($dsatz);

                    // Überprüft ob für die Umfrage Antworten existieren, also die Gesamtanzahl an abgegebenen Stimmen
                        // angezeigt werden kann
                    if (isset($dsatz["stimmen"])) {

                        // Überprüft, ob die ausgewählte Reihe dem höchsten oder niedrigsten Stimmen-Wert entspricht und
                            // erweitert gegebenenfalls den Inhalt des Feldes
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
                echo "<h3>Keine Umfragen vorhanden.</h3>";
            }


            // Überprüft mittels Start- und Enddatum, ob die betroffene Umfrage aktiv oder inaktiv ist und gibt dann
                // jeweils den TD-Block mit der entsprechenden CSS-Klasse zurück
            function getActiveInactive($dsatz) {
                $currentDate = date('Ymd', time());
                $start = $dsatz["startdatum"];
                $end = $dsatz["enddatum"];

                $start = date_create_from_format("Y-m-d", $start);
                $end = date_create_from_format("Y-m-d", $end);

                $start = date_format($start, "Ymd");
                $end = date_format($end, "Ymd");

                if ($currentDate >= $start && $currentDate <= $end) {
                    echo "<td><a class='active' href='/backend/umfrage-details.page.php?uid={$dsatz["u_id"]}'>"
                        . $dsatz["name"] . "</a></td>";
                } else {
                    echo "<td><a class='inactive' href='/backend/umfrage-details.page.php?uid={$dsatz["u_id"]}'>"
                        . $dsatz["name"] . "</a></td>";
                }
            }

            // Schließt die offene Datenbankverbindung wieder
            mysqli_close($con);
        ?>
    </table>

</div>