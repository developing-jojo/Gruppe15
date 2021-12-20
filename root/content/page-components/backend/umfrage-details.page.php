<div class="antworten-uebersicht m-top-30">
    <?php
        $uid = $_GET['uid'];
        if(isset($uid)) {

            // Basis URL zum Root Verzeichnis
            $baseUrl = $_SERVER['DOCUMENT_ROOT'];

            // Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
            require $baseUrl.'/content/dbconnect.php';

            //Lädt die Umfrage, bei der die ID mit der ID aus der URL übereinstimmt
            $uRes = mysqli_query($con, "SELECT * 
                                        FROM `umfragen`
                                        WHERE umfragen.u_id = $uid");
            //Lädt die Antworten, bei der die Fremdschlüssel mit der ID aus der URL übereinstimmen
            $aRes = mysqli_query($con, "SELECT * 
                                        FROM `antworten`
                                        WHERE antworten.umfrage_id = $uid
                                        ORDER BY antworten.stimmen DESC");

            $aSumRes = mysqli_query($con, "SELECT SUM(antworten.stimmen) AS 'stimmen'
                                           FROM `antworten`
                                           WHERE antworten.umfrage_id =  {$uid}");

            // Gesamtanzahl abgegebener Stimmen dieser Umfrage
            $stimmenGesamt = mysqli_fetch_assoc($aSumRes);

            // Ausgabe der Daten aus der geladenen Umfrage
            $umfrage = mysqli_fetch_assoc($uRes);
            echo "<h1>" . $umfrage['name'] . "</h1>";
            echo "<h3>" . $umfrage['beschreibung'] . "</h3>";

            $num = mysqli_num_rows($aRes);

            // Überprüft, ob die Datensätze größer 0 sind und gibt andernfalls eine entsprechende Meldung aus
            if ($num > 0) {
                echo '<div class="table-wrapper antworten-uebersicht-table">';
                echo '<table class="table m-top-30">';

                echo "<th>Umfragename</th>";
                echo "<th>Abgegebene Stimmen</th>";

                $aRes -> data_seek(0);

                // Die Schleife durchläuft das MySql-Query-Ergebnis und baut daraus die entsprechenden Tabellen-Reihen
                while ($dsatz = mysqli_fetch_assoc($aRes)) {
                    $stimmenProzent = 0;
                    if ($stimmenGesamt["stimmen"] > 0) {
                        $stimmenProzent = round(($dsatz["stimmen"]/$stimmenGesamt["stimmen"])*100, 1);
                    }

                    echo "<tr>";
                    echo "<td>" . $dsatz["inhalt"] . "</td>";
                    echo "<td>" . $dsatz["stimmen"] . " (" . $stimmenProzent . "%)</td>";
                    echo "</tr>";
                }

                // Tabellenfuß mit Gesamtanzahl Stimmen
                echo "<tfoot><tr><td></td><td>". $stimmenGesamt["stimmen"] ."</td></tr></tfoot>";


            } else {
                echo "<h3>Diese Umfrage hat noch keine Antworten.</h3>";
            }

            echo "</table>";
            echo "</div>";

            // Schließt die offene Datenbankverbindung wieder
            mysqli_close($con);
        }
    ?>
</div>