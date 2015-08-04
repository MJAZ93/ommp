<?php
date_default_timezone_set('America/Brasilia');

function executarQuery($query) {
    $mysqli = new mysqli("localhost", "root", "", "one_moment");
    if (mysqli_connect_errno()) {
        die("{}");
    }
    $mysqli->autocommit(FALSE);
    $resultado = $mysqli->query($query);
    if (!$mysqli->commit()) {
        die("{}");
    }
    $mysqli->close();
    return $resultado;
}

function executarQueryRetornarId($query) {
    $mysqli = new mysqli("sql100.byethost33.com", "b33_15922660", "c1nd1322", "b33_15922660_pets_rescue");
    if (mysqli_connect_errno()) {
        die("{}");
    }
    $mysqli->autocommit(FALSE);
    $resultado = $mysqli->query($query);
    if (!$mysqli->commit()) {
        die("{}");
    }
    $mysqli->close();
    return $mysqli->insert_id;
}
?>