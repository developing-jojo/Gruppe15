<?php
// Basis URL zum Root Verzeichnis
$baseUrl = $_SERVER['DOCUMENT_ROOT'];

// Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
require $baseUrl . '/content/dbconnect.php';

// Sql-Statements um die Kategorien und Umfragen zu laden
$aSql = "SELECT * FROM antworten";
$uSql = "SELECT * FROM umfragen";
$antwortenRes = mysqli_query($con, $aSql);
$umfragenRes = mysqli_query($con, $uSql);

?>

<div class="form-wrapper">
    <form class="formular" action="/backend/antwort-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Antwort erstellen</legend>
            <label class="form-fields" for="inhalt">Inhalt</label>
            <input class="form-fields form-fields-inp" type="text" name="inhalt" id="inhalt">

            <label class="form-fields" for="umfrage">Umfrage</label>
            <select class="form-fields form-fields-inp" name='uid' id="umfrage">
                <?php
                // Schleife lädt alle verfügbaren Umfragen als Option in das Select
                while($umfrage = mysqli_fetch_array($umfragenRes)) {
                    echo "<option value='{$umfrage['u_id']}'>{$umfrage['name']}</option>";
                }
                ?>
            </select>
            <div class='form-fields'>
                <input class='form-button' type='submit' name='create' value="Erstellen">
            </div>
        </fieldset>
    </form>

    <form class="formular" action="/backend/antwort-bearbeiten.page.php" method="get">
        <fieldset class="form-fieldset">
            <legend>Antworten bearbeiten</legend>

            <label class="form-fields" for="umfrage">Umfrage wählen</label>
            <select class="form-fields form-fields-inp" name='uid' id="umfrage">
                <?php
                // data_seek() setzt den Zähler der Result-Liste auf 0 zurück
                $umfragenRes -> data_seek(0);

                // Schleife lädt alle verfügbaren Umfragen zum Bearbeiten der Antworten als Option in das Select
                while($umfrage = mysqli_fetch_array($umfragenRes)) {
                    echo "<option value='{$umfrage['u_id']}'>{$umfrage['name']}</option>";
                }
                ?>
            </select>
            <div class="form-fields" >
                <input class='form-button' type='submit' value="Bearbeiten">
            </div>
        </fieldset>
    </form>

    <form class="formular" action="/backend/antwort-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Antwort löschen</legend>
            <label class="form-fields" for="antwort">Antwort wählen</label>
            <select class="form-fields form-fields-inp" name='aid' id="antwort">
                <?php
                // data_seek() setzt den Zähler der Result-Liste auf 0 zurück
                $antwortenRes -> data_seek(0);

                // Schleife lädt alle verfügbaren Antworten zum Löschen als Option in das Select
                while($antwort = mysqli_fetch_array($antwortenRes)) {
                    echo "<option value='{$antwort['a_id']}'>{$antwort['inhalt']}</option>";
                }
                ?>
            </select>
            <div class="form-fields" >
                <input class='form-button' type='submit' name='delete' value="Löschen">
            </div>
        </fieldset>
    </form>
</div>