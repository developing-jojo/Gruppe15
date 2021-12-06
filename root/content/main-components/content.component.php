<!-- Hier kommt HTML-Content -->

<?php

// PHP-Content
echo "Seiten-Inhalt";

    // Aktuelle Seite: $path = $_SERVER['REQUEST_URI'];
    // switch/case für alle seiten zum anzeigen des contents:

/**
    switch ($path) {
    case 'umfrage-startseite':
        require('../page-components/umfrage-startseite.page.php');
        break;
    case 'umfrage-details':
        require('../page-components/umfrage-details.page.php');
        break;
    case 'umfrage-ergebnisse':
        require('../page-components/umfrage-ergebnisse.page.php');
        break;
    ...
    default:
        require(../page-components/home.page.php);
    }
 **/

    // Alternativ, wenn euch das zu kompliziert erscheint, einfach header.component & footer.component auf jeder page
    // einbinden und die einzelnen pages auf der home-page verlinken.

?>

<!-- Hier kommt HTML-Content -->
