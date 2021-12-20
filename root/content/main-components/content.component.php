<div class="main-content">
    <?php

        // Angefragter Pfad
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Basis URL
        $baseUrl = $_SERVER['DOCUMENT_ROOT'];

        // Lädt den Content dynamisch, abhängig von der angefragten URL
        if($path == '' || $path == '/') {
            require $baseUrl . '/content/page-components/home.page.php';
        } else {
            require $baseUrl . '/content/page-components' . $path;
        }

    ?>
</div>
