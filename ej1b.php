<HTML>
<HEAD><TITLE> EJ1-Bucles</TITLE></HEAD>
<BODY>
<?php
    $numero="168";
    settype($numero,'integer');

    if ($numero == 0)
    {
        return "0";
    }

    $binario = "";
    
    while ($numero > 0)
    {
        $resto = $numero % 2;
        $binario = $resto . $binario;
        $numero = intdiv($numero, 2);
    }
    echo $binario;

?>
</BODY>
</HTML>