<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Formulari Algorisme 3n + 1</title>
</head>

<body>
    <div>
        <h3>Algorisme 3n + 1</h3>
        <form action="" method="post" id="myform" name="myform">

            <label>Text</label> <input type="number" value="" size="30" maxlength="100" name="mynumber" id="" /><br /><br />
        
            <button id="mysubmit" type="submit">Submit</button><br /><br />

        </form>
    </div>
    <div style="margin: 30px 10%;">
        <?php
            /* ----- Controls de paràmetres -----*/
            
            if (!array_key_exists("mynumber", $_REQUEST) ) {
                die( "No he rebut el número" );
            }
            
            $initial_number = $_REQUEST["mynumber"];

            if ($initial_number <=1 ) {
                die("Cal posar un número superior a 1");
            }

            $number = $initial_number;
            $cycles = 0;
            $max = $number;
            $sequence = array();


            while ($number != 1) {
                // Comprova si el numero és par o impar
                if ($number % 2 == 0) {
                    // Com que el numero és par el dividix entre 2
                    $number = $number / 2;
                    $sequence[] = $number;
                } else {
                    // Com que el numero és inpar el multiplica per 3 i suma 1
                    $number = $number * 3 + 1;
                    $sequence[] = $number;
                    // Comprova si el numero és mes gran que el maxim anterior
                    if ($number > $max) $max = $number;
                }
                $cycles++;
            }

            echo "La seqüència del $initial_number és {";
            for($i = 0, $size = count($sequence)-1; $i < $size; $i++) {
                echo $sequence[$i] . ", ";
            }
            echo $sequence[count($sequence)-1] . "}, despres de $cycles iteracions i arribant a un màxim de $max";
        ?>
    </div>
</body>
</html>