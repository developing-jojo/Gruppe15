<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Darlyn Becker, Alina Heinowski, Anna-Mieke Kuper und Frank Rommel">
        <title>Umfrage Tool</title>

        <!-- Verlinkungen zur Google-API für die Nutzung einer Schriftart und eines Icon-Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <!-- Mit PHP wird überprüft, ob die aktuelle Seite aus dem Backend kommt, um die CSS korrekt zu laden -->
        <?php
            // Basis URL zum Root Verzeichnis
            $baseUrl = $_SERVER['HTTP_HOST'];
            // Verwendetes Server-Protokoll
            $protocol = $_SERVER['SERVER_PROTOCOL'];

            // Überprüft welches Protokoll verwendet wird und füllt die Variable für die Verlinkung entsprechend
            if(strpos($protocol, 'HTTPS') !== false) {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }
        ?>

        <!-- Die CSS und JavaScript Datei werden mit der zusammengebauten URL und dem relativen Pfad geladen -->
        <link rel="stylesheet" href="<?php echo $protocol . $baseUrl . '/css/main.css'; ?>">
        <script src="<?php echo $protocol . $baseUrl . '/js/validation.js'; ?>"></script>
    </head>
    <body>

    <!-- Der globale Header, Main-Content und Footer werden geladen -->
    <?php

        require "content/main-components/header.component.php";
        require "content/main-components/content.component.php";
        require "content/main-components/footer.component.php";

    ?>

    </body>
</html>

