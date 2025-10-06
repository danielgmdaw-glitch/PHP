<HTML>
<HEAD><TITLE> EJ1-Formularios</TITLE></HEAD>
<BODY>
<?php
    echo "<h1>Calculadora</h1>";

    function suma($n1, $n2)
    {
        return $n1 + $n2;
    }

    function resta($n1, $n2)
    {
        return $n1 - $n2;
    }

    function producto($n1, $n2)
    {
        return $n1 * $n2;
    }

    function division($n1, $n2)
    {
        if ($n2 == 0) {
            return "Error: división por 0";
        } else {
            return $n1 / $n2;
        }
    }

    function limpiar_campos($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Procesar formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = limpiar_campos($_POST['num1']);
        $num2 = limpiar_campos($_POST['num2']);
        $operacion = limpiar_campos($_POST['operacion']);
        
        switch ($operacion) {
            case "suma":
                echo "<p><b>Resultado:</b> " . suma($num1, $num2) . "</p>";
                break;
            case "resta":
                echo "<p><b>Resultado:</b> " . resta($num1, $num2) . "</p>";
                break;
            case "producto":
                echo "<p><b>Resultado:</b> " . producto($num1, $num2) . "</p>";
                break;
            case "division":
                echo "<p><b>Resultado:</b> " . division($num1, $num2) . "</p>";
                break;
            default:
                echo "<p><b>Operación no válida</b></p>";
        }

       
    }
?>
</BODY>
</HTML>
