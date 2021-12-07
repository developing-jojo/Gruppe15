<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Umfrage Tool</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <!-- Mit PHP wird überprüft, ob die aktuelle Seite aus dem Backend kommt um die Css korrekt zu laden -->
        <link rel="stylesheet"
              href="<?php
                        $uri = $_SERVER['REQUEST_URI'];

                        if (substr($uri, 0, 8) === '/backend') {
                            echo '../css/main.css';
                        } else {
                            echo 'css/main.css';
                        }
                    ?>">
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

