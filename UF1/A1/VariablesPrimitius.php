<?php
// $i és una variable de tipus integer
$i = 12;
gettypevar( $i , "\$i");

// $b és una variable de tipus boolea
$b = true;
gettypevar( $b , "\$b");

// $f és una variable de tipus coma flotant (double)
$f = 0.5;
gettypevar( $f , "\$f");

// $s és una variable de tipus cadena de caracters (string)
$s = "Això és una cadena de caràcters";
gettypevar( $s , "\$s");

$tipus_de_gettype = gettype( gettype( $i ) );
echo "El tipus del valor que retorna el gettype  és $tipus_de_gettype <br>\n";

function gettypevar( $var, $varname ) {
    $tipus_de_var = gettype( $var );
    echo "La variable $varname conté el valor $var i és del tipus $tipus_de_var <br>\n";
}
?>