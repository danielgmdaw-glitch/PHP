<?php
    echo"<h1>Numero decimal</h1>";

    function limpiar_campos($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    function conversorBinario($numero)
    {
        if ($numero == 0)
        {
            return "0";
        }

        $binario = "";
        
        while ($numero > 0)
        {
            $resto = $numero % 2;
            $binario = $resto . $binario;
            //intdiv() sirve para hacer división y coger la parte entera
            $numero = intdiv($numero, 2);
        }
        // Rellenar con ceros a la izquierda hasta 8 bits
        $binario = str_pad($binario, 8, "0", STR_PAD_LEFT);
        return $binario;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $num = limpiar_campos($_POST['num']);
    }

    echo "<label>Numero Decimal: </label>";
    echo "<input value=" . $num.">";
    echo "<br>";
    echo "<br>";
    echo "<label>Numero Binario: </label>";
    echo "<input value=" . conversorBinario($num).">";

    
?>