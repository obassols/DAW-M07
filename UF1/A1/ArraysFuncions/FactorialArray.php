<?php
$test_array = [4,5,2,3,6];

var_dump($test_array);
echo "<br>";
var_dump(factorialArray($test_array));

function factorialArray( $array ): bool | array  {
    if (is_array($array)) {
        return false;
    }
    $factorial_array = array();

    foreach($array as $number) {
        // Comprova que el $number sigui un numero o si es un numero negatiu
        if (is_int($number) && $number > -1) {
            array_push($factorial_array, factorialNombre($number));
        } else {
            return false;
        }
    }
    return $factorial_array;
}

function factorialNombre( int $num ) {
    // Si el numero és mes gran a 1 crida la mateixa funcio amb el $num - 1, sino retorna 1
    if ( $num > 1 ) {
        return $num * factorialNombre( $num - 1 );
    } else {
        return 1;
    }
}

?>