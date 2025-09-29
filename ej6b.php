<HTML>
<HEAD><TITLE> EJ6-Factorial</TITLE></HEAD>
<BODY>
<?php
    //Mostrar por pantalla el factorial de un número usando bucles

    $factorial = 5;
    $resultado = 1;

    for ($i=$factorial; $i > 1; $i--)
    { 
        $resultado *= $i;
    }
    echo "El factorial de $factorial es $resultado";
    
?>
</BODY>
</HTML>