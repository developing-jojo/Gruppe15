<div class="table-wrapper">

    <table class="table m-top-30">
        <?php
            // Basis URL
            $baseUrl = $_SERVER['DOCUMENT_ROOT'];

            require $baseUrl.'/content/dbconnect.php';
            $res = mysqli_query($con, "SELECT * 
                                        FROM `umfragen`");
            //WHERE CURRENT_DATE BETWEEN umfragen.startdatum AND DATE_ADD(umfragen.enddatum, INTERVAL 1 DAY);

            $num = mysqli_num_rows($res);

            if ($num > 0) {
                echo "<th>Umfragename</th>";
                echo "<th>Kategorie</th>";

                while ($dsatz = mysqli_fetch_assoc($res))
                {
                    echo "<tr>";
                    echo "<td>" . $dsatz["name"] . "</td>";
                    echo "<td>" . $dsatz["beschreibung"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<h3>Keine aktiven Umfragen vorhanden.</h3>";
            }



        ?>
    </table>

</div>