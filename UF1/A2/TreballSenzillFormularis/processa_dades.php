<?php
    echo "El valor de text és: " . $_REQUEST["mytext"];
    echo "<br>";
    echo "<br>";

    echo "El valor de la seleccio radio és: " . $_REQUEST["myradio"];
    echo "<br>";
    echo "<br>";

    foreach($_REQUEST["mycheckbox"] as $key => $value) {
        echo "El valor de la checkbox numero " . $key . " és: " . $value;
        echo "<br>";
    }
    echo "<br>";

    echo "L'item selecionat de la seleccio és: " . $_REQUEST["myselect"];
    echo "<br>";
    echo "<br>";

    echo "El valor de l'area de text és: " . $_REQUEST["mytextarea"];
    echo "<br>";
    echo "<br>";
?>