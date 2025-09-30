<HTML>
<HEAD><TITLE> EJ4-Arrays</TITLE></HEAD>
<BODY>
<?php
    //A partir del array definido en el ejercicio anterior crear un nuevo array que almacene
    //los números binarios en orden inverso.
    
    //binarios
    $arrayBinario = array();
    $arrayOctales = array();

    for ($i=0; $i < 20; $i++)
    { 
        $numBinario = "";
        $num = $i;

        if($num == 0)
        {
            $numBinario = 0;
        } else {
            while ($num > 0)
            {
                $resto = $num % 2;
                $numBinario = $resto . $numBinario;
                //intdiv() sirve para hacer división y coger la parte entera
                $num = intdiv($num, 2);
            }
        }

        $arrayBinario[$i] = $numBinario; 

        $numOctales = "";
        $num = $i;

        if($num == 0)
        {
            $numOctales = 0;
        } else {
            while ($num > 0)
            {
                $resto = $num % 8;
                $numOctales = $resto . $numOctales;
                $num = intdiv($num, 8);
            }
        }

        $arrayOctales[$i] = $numOctales;
    }

    $binariosInversos = array();

    for ($i = count($arrayBinario) - 1; $i >= 0 ; $i--)
    { 
        $binariosInversos[] = $arrayBinario[$i];
    }
    
    echo "<table border=1>";
    echo "<caption>Tabla binarios inversa</caption>";

    echo "<tr>";
    echo "<th>Indice</th>";
    echo "<th>Binarios</th>";
    echo "<th>Octales</th>";
    echo "<th>Binarios Inversos</th>";
    echo "</tr>";

    for ($i=0; $i < 20; $i++)
    { 
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>$arrayBinario[$i]</td>";
        echo "<td>$arrayOctales[$i]</td>";
        echo "<td>$binariosInversos[$i]</td>";
        echo "</tr>";
    }

?>
</BODY>
</HTML>