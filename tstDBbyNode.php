<?php
    include "database.php";
    $sql = "SELECT * FROM report_data";
    $reportData = Database::sqlQuery($sql);
    print_r($reportData);
?>