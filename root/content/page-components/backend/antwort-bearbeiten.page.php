<?php
// Basis URL zum Root Verzeichnis
$baseUrl = $_SERVER['DOCUMENT_ROOT'];

// Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
require $baseUrl . '/content/dbconnect.php';

//Sql-Statements um die Kategorien und Umfragen zu laden
$aSql = "SELECT * FROM antworten WHERE antworten.umfrage_id = " . $_GET["uid"];
$uSql = "SELECT * FROM umfragen WHERE umfragen.u_id = " . $_GET["uid"];
$antwortenRes = mysqli_query($con, $aSql);

?>

<div class="form-wrapper">

    <form class="formular" action="/backend/antwort-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Antworten bearbeiten</legend>

            <?php
                echo "<input hidden name='uid' value='{$_GET["uid"]}'>";

                $count = 1;
                while($antwort = mysqli_fetch_assoc($antwortenRes)) {
                    echo "<label class='form-fields' for='inhalt-{$antwort["a_id"]}'>Antwort " . $count . " anpassen </label>";
                    echo "<input class='form-fields form-fields-inp' type='text' name='{$antwort["a_id"]}' id='inhalt-{$antwort["a_id"]}' value='{$antwort["inhalt"]}'>";
                    $count++;
                }
            ?>

            <div class="form-fields" >
                <input class='form-button' type='submit' name='edit' value="Bearbeiten">
            </div>
        </fieldset>
    </form>

</div>