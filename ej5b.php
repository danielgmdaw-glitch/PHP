<HTML>
<HEAD><TITLE> EJ1-Bucles</TITLE></HEAD>
<BODY>
<?php
//Mostrar por pantalla la tabla de multiplicar de un número usando bucles

    $numero=7;
    
    echo "La tabla de multiplcar del número $numero es :<br>";
    echo "<table border=1>";
    echo "<caption>Tabla del $numero </caption>";
    for ($i=1; $i <= 10 ; $i++)
    { 
        $resultado = $numero * $i;
        echo "<tr>";
        echo "<th>$numero x $i</th>"; 
        echo "<th>$resultado</th>"; 
        echo "</tr>";
    }
    echo "</table>";
    
?>
</BODY>
</HTML>