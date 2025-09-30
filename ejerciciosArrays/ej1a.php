<HTML>
<HEAD><TITLE> EJ1-Arrays</TITLE></HEAD>
<BODY>
<?php
    //Definir un array y almacenar los 20 primeros números impares. Mostrar en la salida
    //una tabla como la de la figura
    
    $numImpares= array();
    $sumador = 0;

    for ($i=0; $i < 20; $i++) 
    { 
       $numImpares[$i] = $i * 2 + 1;
    }

    echo "<table border=1>";
    echo "<caption>Tabla de impares</caption>";

    echo "<tr>";
    echo "<th>Indice</th>";
    echo "<th>Valor</th>";
    echo "<th>Suma</th>";
    echo "</tr>";

    for ($i=0; $i < count($numImpares); $i++)
    { 
        $sumador += $numImpares[$i];
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>$numImpares[$i]</td>";
        echo "<td>$sumador</td>";
        echo "</tr>";
    }

    echo "</table>";
?>
</BODY>
</HTML>