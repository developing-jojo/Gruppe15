<div class="main-content">
<?php

    // Aktuelle URI
    $path = $_SERVER['REQUEST_URI'];

    // Basis URL
    $baseUrl = $_SERVER['DOCUMENT_ROOT'];

    // switch/case für alle Seiten zum Anzeigen des Contents:
    switch ($path) {
    case '/aktive-umfragen':
        require ($baseUrl.'/content/page-components/umfrage-startseite.page.php');
        break;
    case '/umfrage-details':
        require($baseUrl.'/content/page-components/umfrage-details.page.php');
        break;
    case '/umfrage-ergebnisse':
        require($baseUrl.'/content/page-components/umfrage-ergebnisse.page.php');
        break;
    case '/backend/umfrage-formular':
        require($baseUrl.'/content/page-components/backend/umfrage-formular.page.php');
        break;
    case '/backend/antwort-formular':
        require($baseUrl.'/content/page-components/backend/antwort-formular.page.php');
        break;
    case '/backend/kategorie-formular':
        require($baseUrl.'/content/page-components/backend/kategorie-formular.page.php');
        break;
    case '/backend/auswertungen':
        require($baseUrl.'/content/page-components/backend/umfrage-uebersicht.page.php');
        break;
    case '/backend/umfrage-details':
        require($baseUrl.'/content/page-components/backend/umfrage-details.page.php');
        break;
    case '/backend/uebersicht':
        require($baseUrl.'/content/page-components/backend/uebersicht.page.php');
        break;
    // Der default wird geladen, wenn keine der oben stehenden Optionen zutrifft
    default:
        require ($baseUrl.'/content/page-components/home.page.php');
    }

?>
</div>
