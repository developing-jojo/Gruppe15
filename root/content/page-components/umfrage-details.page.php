<div class="form-wrapper m-top-30">
    <div class="card">
        <form action="/umfrage-gesendet.php" method="post">
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
                                               WHERE antworten.umfrage_id = $uid");

                // Ausgabe der Daten aus der geladenen Umfrage
                $umfrage = mysqli_fetch_assoc($uRes);
                echo "<h2>" . $umfrage['name'] . "</h2>";
                echo "<h4>" . $umfrage['beschreibung'] . "</h4>";

                $num = mysqli_num_rows($aRes);

                if ($num > 0) {
                    echo "<div class='antworten'>";
                    // Mit einer While-Schleife werden die Datensätze durchlaufen und die Antworten als Radio-Optionen ausgegeben
                    while ($dsatz = mysqli_fetch_assoc($aRes))
                    {
                        echo "<div class='antwort-opt'>";
                        echo "<input type='radio' name='antwort' id='antwort-{$dsatz["a_id"]}' value='{$dsatz["a_id"]}'>";
                        echo "<label for='antwort-{$dsatz["a_id"]}'>" . $dsatz["inhalt"] . "</label>";
                        echo "</div>";
                    }
                    echo "</div>";


                    echo "<input type='hidden' name='uid' value='$uid'>";

                    echo "<div class='form-button-wrapper'>";
                    echo "<input class='form-button' type='submit' name='gesendet'>";
                    echo "</div>";

                } else {
                    echo "<div class='m-bottom-150 m-top-30'><h3>Keine Antworten vorhanden.</h3>";
                    echo "<a href='/backend/antwort-formular.page.php'><h3>Neue Antworten anlegen</h3></a></div>";
                }

                mysqli_close($con);
            }
        ?>
        </form>
    </div>
</div>