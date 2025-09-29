<HTML>
<HEAD><TITLE> EJ2-Arrays</TITLE></HEAD>
<BODY>
<?php
    //Modificar el ejemplo anterior para que calcule la media de los valores que están en
    //las posiciones pares y las posiciones impares.
    
    $numImpares= array();
    $sumador = 0;

    for ($i=0; $i < 20; $i++) 
    { 
       $numImpares[$i] = $i * 2 + 1;
    }

    //media Pares
    $sumaPares = 0;
    $contadorPares = 0;
    $mediaPares = 0;

    for ($i=0; $i < count($numImpares); $i+=2)
    { 
        if($i % 2 == 0)
        {
            $sumaPares += $numImpares[$i];
            $contadorPares++;
        }
    }

    $mediaPares = $sumaPares / $contadorPares;

    //media Impares
    $sumaImpares = 0;
    $contadorImpares = 0;
    $mediaImpares = 0;

    for ($i=1; $i < count($numImpares); $i+=2)
    { 
        if($i % 2 != 0)
        {
            $sumaImpares += $numImpares[$i];
            $contadorImpares++;
        }
    }

    $mediaImpares = $sumaImpares / $contadorImpares;

    echo "<table border=1>";
    echo "<caption>Tabla de impares</caption>";

    echo "<tr>";
    echo "<th>Indice</th>";
    echo "<th>Valor</th>";
    echo "<th>Suma</th>";
    echo "<th>Media Pares</th>";
    echo "<th>Media Impares</th>";
    echo "</tr>";

    for ($i=0; $i < count($numImpares); $i++)
    { 
        $sumador += $numImpares[$i];
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>$numImpares[$i]</td>";
        echo "<td>$sumador</td>";
        echo "<td>$mediaPares</td>";
        echo "<td>$mediaImpares</td>";
        echo "</tr>";
    }

    echo "</table>";
?>
</BODY>
</HTML>