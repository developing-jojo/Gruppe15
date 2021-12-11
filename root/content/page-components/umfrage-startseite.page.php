<div class="table-wrapper">

    <table class="table m-top-30">
        <?php
            // Basis URL zum Root Verzeichnis
            $baseUrl = $_SERVER['DOCUMENT_ROOT'];

            // Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
            require $baseUrl.'/content/dbconnect.php';

            // Ein MySql Query-Aufruf zum Selektieren und Filtern der benötigten Daten
            $res = mysqli_query($con, "SELECT umfragen.u_id, umfragen.name, kategorien.bezeichnung
                                        FROM `umfragen`
                                        LEFT JOIN `kategorien`
                                        ON umfragen.kategorie_id = kategorien.k_id
                                        WHERE CURRENT_DATE 
                                        BETWEEN umfragen.startdatum 
                                        AND DATE_ADD(umfragen.enddatum, INTERVAL 1 DAY);");

            // Zählt die Anzahl aller Datensätze der Tabelle mithilfe der Reihen-Nummer
            $num = mysqli_num_rows($res);

            // Überprüft, ob die Datensätze größer 0 sind und gibt andernfalls eine entsprechende Meldung aus
            if ($num > 0) {
                echo "<th>Umfragename</th>";
                echo "<th>Kategorie</th>";

                // Mit einer While-Schleife werden die Datensätze durchlaufen und die Daten in Reihen ausgegeben
                while ($dsatz = mysqli_fetch_assoc($res))
                {
                    echo "<tr>";
                    echo "<td><a class='card-link' href='/umfrage-details.page.php?uid={$dsatz['u_id']}'>" . $dsatz["name"] . "</a></td>";
                    echo "<td>" . $dsatz["bezeichnung"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<h3>Keine aktiven Umfragen vorhanden.</h3>";
            }

            // Schließt die offene Datenbankverbindung wieder
            mysqli_close($con);
        ?>
    </table>

</div>