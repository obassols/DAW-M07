<style>
    /* Estils de la taula */
    table, td {
        border:1px solid black;
        border-collapse: collapse;
        margin: auto;
    }
    td {
        width: 25px;
        height: 25px;
        text-align: center;
    }
</style>
<?php

$test = creaMatriu(4);
echo mostraMatriu($test);
echo "<br>";
echo mostraMatriu(transposaMatriu($test));
echo "<br>";

$test2 = array(array(1,2,3,4,5),array(1,2,3,4),array(1,2,3,4,5,6));
echo mostraMatriu($test2);
echo "<br>";
echo mostraMatriu(transposaMatriu($test2));
echo "<br>";

function creaMatriu( int $num ): array {
    $array = array_fill(0, $num, array_fill(0, $num, null));

    for ($col = 0; $col < $num; $col++) {
        for ($row = 0; $row < $num; $row++) {
            if ( $col < $row ) {
                $array[$col][$row] = $col + $row;
            } elseif ( $col > $row ) {
                $array[$col][$row] = rand(10, 20);
            } else {
                $array[$col][$row] = "*";
            }
        }
    }
    return $array;
}

function mostraMatriu( array $col ): string {
    $table = "<table>";
    foreach( $col as $row ) {
        $table = $table . "<tr>";
        foreach ( $row as $cell) {
            $table = $table . "<td> $cell </td>";
        }
        $table = $table . "</tr>";
    }
    $table = $table . "</table>";
    return $table;
}

function transposaMatriu( array $array ): array {
    $matriu = array_fill(0, count($array), array());
    for($col = 0; $col < count($array); $col++) {
        for ($row = 0; $row < count($array[$col]); $row++) {
            $matriu[$row][$col] = $array[$col][$row];
        }
    }
    return $matriu;
}
?>