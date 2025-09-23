<HTML>
<HEAD><TITLE> EJ1-Bucles</TITLE></HEAD>
<BODY>
<?php
    $numero="48";
    $base = "2";
    settype($numero,'integer');
    settype($base,'integer');

    $resultado = "";

    if($base < 2 || $base > 9)
    {
        echo "Base no válida";
    } else if($numero == 0) {
        echo "0";
    } else {
        while ($numero > 0)
        {
            $resto = $numero % $base;
            $resultado = $resto . $resultado;
            //intdiv() sirve para hacer división y coger la parte entera
            $numero = intdiv($numero, $base);
        }

        //Si la base es 2, rellenamos con ceros a la izquierda hasta 8 caracteres
        if ($base == 2)
             {
            $resultado = str_pad($resultado, 8, "0", STR_PAD_LEFT);
        }

        echo $resultado;
    }

?>
</BODY>
</HTML>