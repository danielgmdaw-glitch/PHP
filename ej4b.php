<HTML>
<HEAD><TITLE> EJ1-Bucles</TITLE></HEAD>
<BODY>
<?php
//Mostrar por pantalla la tabla de multiplicar de un número usando bucles

    $numero="7";
    
    echo "La tabla de multiplcar del número $numero es :<br>";

    for ($i=1; $i <= 10 ; $i++)
    { 
        $resultado = $numero * $i;
        echo "$numero x $i = $resultado<br>"; 
    }
    
?>
</BODY>
</HTML>