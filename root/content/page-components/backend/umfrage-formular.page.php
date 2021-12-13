<?php
// Basis URL zum Root Verzeichnis
$baseUrl = $_SERVER['DOCUMENT_ROOT'];

// Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
require $baseUrl . '/content/dbconnect.php';

//Sql-Statements um die Kategorien und Umfragen zu laden
$kSql = "SELECT * FROM kategorien";
$uSql = "SELECT * FROM umfragen";
$kategorienRes = mysqli_query($con, $kSql);
$umfragenRes = mysqli_query($con, $uSql);

?>

<div class="form-wrapper">
    <form class="formular" action="/backend/umfrage-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Umfrage erstellen</legend>
            <label class="form-fields" for="name">Name</label>
            <input class="form-fields" type="text" name="name" id="name">

            <label class="form-fields" for="beschreibung">Beschreibung</label>
            <textarea class="form-fields" type="text" name="beschreibung" id="beschreibung"></textarea>

            <label class="form-fields" for="kategorie">Kategorie</label>
            <select class="form-fields" name='kid' id="kategorie">
                <?php
                $num = mysqli_num_rows($kategorienRes);

                while($kategorie = mysqli_fetch_array($kategorienRes)) {
                    echo "<option value='{$kategorie['k_id']}'>{$kategorie['bezeichnung']}</option>";
                }
                ?>
            </select>
            <div class='form-fields'>
                <input class='form-button' type='submit' name='create' value="Erstellen">
            </div>
        </fieldset>
    </form>

    <form class="formular" action="/backend/umfrage-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Umfrage bearbeiten</legend>
            <label class="form-fields" for="umfrage">Umfrage wählen</label>
            <select class="form-fields" name='uid' id="umfrage">
                <?php
                $num = mysqli_num_rows($umfragenRes);

                while($umfrage = mysqli_fetch_array($umfragenRes)) {
                    echo "<option value='{$umfrage['u_id']}'>{$umfrage['name']}</option>";
                }
                ?>
            </select>

            <label class="form-fields" for="name">Namen anpassen</label>
            <input class="form-fields" type="text" name="name" id="name">

            <label class="form-fields" for="beschreibung">Beschreibung anpassen</label>
            <textarea class="form-fields" type="text" name="beschreibung" id="beschreibung"></textarea>

            <label class="form-fields" for="kategorie">Kategorie wählen</label>
            <select class="form-fields" name='kid' id="kategorie">
            <?php
            $kategorienRes -> data_seek(0);
            $num = mysqli_num_rows($kategorienRes);

            while($kategorie = mysqli_fetch_array($kategorienRes)) {
                echo "<option value='{$kategorie['k_id']}'>{$kategorie['bezeichnung']}</option>";
            }
            ?>
            </select>
            <div class="form-fields" >
                <input class='form-button' type='submit' name='edit' value="Bearbeiten">
            </div>
        </fieldset>
    </form>

    <form class="formular" action="/backend/umfrage-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Umfrage löschen</legend>
            <label class="form-fields" for="umfrage">Umfrage wählen</label>
            <select class="form-fields" name='uid' id="umfrage">
                <?php
                $umfragenRes -> data_seek(0);
                $num = mysqli_num_rows($umfragenRes);

                while($umfrage = mysqli_fetch_array($umfragenRes)) {
                    echo "<option value='{$umfrage['u_id']}'>{$umfrage['name']}</option>";
                }
                ?>
            </select>
            <div class="form-fields" >
                <input class='form-button' type='submit' name='delete' value="Löschen">
            </div>
        </fieldset>
    </form>
</div>