<?php
    // Basis URL zum Root Verzeichnis
    $baseUrl = $_SERVER['DOCUMENT_ROOT'];

    // Lädt eine separate Datei, um eine Verbindung mit der DB herzustellen
    require $baseUrl . '/content/dbconnect.php';

    //Sql-Statement um die Kategorien zu laden
    $sql = "SELECT * FROM kategorien";
    $kategorienRes = mysqli_query($con, $sql);

?>

<div class="form-wrapper">
    <form class="formular" action="/backend/kategorie-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Kategorie erstellen</legend>
            <label class="form-fields" for="bezeichnung">Bezeichnung</label>
            <input class="form-fields form-fields-inp" type="text" name="bezeichnung" id="bezeichnung">
            <div class='form-fields'>
                <input class='form-button' type='submit' name='create' value="Erstellen">
            </div>
        </fieldset>
    </form>

    <form class="formular" action="/backend/kategorie-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Kategorie bearbeiten</legend>
            <label class="form-fields" for="kategorie">Kategorie wählen</label>
            <select class="form-fields form-fields-inp" name='kid' id="kategorie">
                <?php
                    $num = mysqli_num_rows($kategorienRes);

                    while($kategorie = mysqli_fetch_array($kategorienRes)) {
                        echo "<option value='{$kategorie['k_id']}' onselect=''>{$kategorie['bezeichnung']}</option>";
                    }
                ?>
            </select>
            <label class="form-fields" for="bezeichnung">Bezeichnung anpassen</label>
            <input class="form-fields form-fields-inp" type="text" name="bezeichnung" id="bezeichnung" onload="test()">
            <div class="form-fields" >
                <input class='form-button' type='submit' name='edit' value="Bearbeiten">
            </div>
        </fieldset>
    </form>

    <form class="formular" action="/backend/kategorie-post.php" method="post">
        <fieldset class="form-fieldset">
            <legend>Kategorie löschen</legend>
            <label class="form-fields" for="kategorie">Kategorie wählen</label>
            <select class="form-fields form-fields-inp" name='kid' id="kategorie">
                <?php
                $kategorienRes->data_seek(0);
                $num = mysqli_num_rows($kategorienRes);

                while($kategorie = mysqli_fetch_assoc($kategorienRes)) {
                    echo "<option value='{$kategorie['k_id']}'>{$kategorie['bezeichnung']}</option>";
                }
                ?>
            </select>
            <div class="form-fields" >
                <input class='form-button' type='submit' name='delete' value="Löschen">
            </div>
        </fieldset>
    </form>
</div>