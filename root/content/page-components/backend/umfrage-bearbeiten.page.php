<?php
// Basis URL zum Root Verzeichnis
$baseUrl = $_SERVER['DOCUMENT_ROOT'];

// Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
require $baseUrl . '/content/dbconnect.php';

// Sql-Statements um die Kategorien und Umfragen zu laden
$kSql = "SELECT * FROM kategorien";
$uSql = "SELECT * FROM umfragen WHERE umfragen.u_id = " . $_GET["uid"];
$kategorienRes = mysqli_query($con, $kSql);
$umfragenRes = mysqli_query($con, $uSql);

// Speichert die Umfrage, die bearbeitet werden soll
$umfrage = mysqli_fetch_assoc($umfragenRes);

// Speichert die benötigten Werte der Attribute der zu bearbeitenden Umfrage zwischen
$name = $umfrage["name"];
$bes = $umfrage["beschreibung"];
$start = $umfrage["startdatum"];
$end = $umfrage["enddatum"];
$kat = $umfrage["kategorie_id"];

?>

<div class="form-wrapper">

    <form class="formular" action="/backend/umfrage-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Umfrage bearbeiten</legend>

            <!-- Verstecktes Input Feld zum Übermitteln der Umfrage-Id im POST -->
            <?php echo "<input name='uid' value='{$_GET['uid']}' hidden>" ?>

            <!-- Alle Input-Felder bekommen den zwischengespeicherten Wert aus der Datenbank als value-Attribut, damit sie vorausgefüllt sind -->
            <label class="form-fields" for="name">Namen anpassen</label>
            <?php echo "<input class='form-fields form-fields-inp' type='text' name='name' id='name' value='$name'>" ?>

            <label class="form-fields" for="beschreibung">Beschreibung anpassen</label>
            <?php echo "<input class='form-fields form-fields-inp' type='text' name='beschreibung' id='beschreibung' value='$bes'>" ?>

            <label class="form-fields" for="kategorie">Kategorie wählen</label>
            <select class="form-fields form-fields-inp" name='kid' id="kategorie">
                <?php
                // data_seek() setzt den Zähler der Result-Liste auf 0 zurück
                $kategorienRes -> data_seek(0);
                $num = mysqli_num_rows($kategorienRes);

                // Schleife gibt alle existierenden Kategorien als Option im Select aus
                while($kategorie = mysqli_fetch_array($kategorienRes)) {
                    if ($kategorie['k_id'] === $kat) {
                        echo "<option selected value='{$kategorie['k_id']}'>{$kategorie['bezeichnung']}</option>";
                    } else {
                        echo "<option value='{$kategorie['k_id']}'>{$kategorie['bezeichnung']}</option>";
                    }
                }
                ?>
            </select>

            <div class="date-picker">
                <label class="form-fields" for="start">Startdatum</label>
                <?php echo "<input class='form-fields form-fields-inp' type='date' name='start' id='start' value='$start'>"?>

                <label class="form-fields" for="end">Enddatum</label>
                <?php echo "<input class='form-fields form-fields-inp' type='date' name='end' id='end' value='$end'>"?>
            </div>
            <div class="form-fields" >
                <input class='form-button' type='submit' name='edit' value="Bearbeiten">
            </div>
        </fieldset>
    </form>

</div>