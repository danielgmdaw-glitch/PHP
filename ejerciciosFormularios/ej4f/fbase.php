<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EJ4-Formularios</title>
</head>
<body>
    <h2>Cambio de bases</h2>
    <?php 
    function limpiar_campos($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function convertirBase($numero, $baseOrigen, $baseDestino)
    {
        $resultado = base_convert($numero, $baseOrigen, $baseDestino);

        return $resultado;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $numero = $_POST["numero"];
        $baseOrigen = (int)$_POST["base_origen"];
        $baseDestino = (int)$_POST["base_destino"];

        $resultado = convertirBase($numero, $baseOrigen, $baseDestino);

        echo "<h2>Resultado</h2>";
        echo "<p>Número <strong>$numero</strong> en base $baseOrigen = <strong>$resultado</strong> en base $baseDestino.</p>";
    }
    ?>

    <form method="post">
        <label>Número:</label>
        <input type="text" name="numero" required><br><br>

        <label>Base origen:</label>
        <input type="number" name="base_origen" required><br><br>

        <label>Base destino:</label>
        <input type="number" name="base_destino" required><br><br>

        <input type="submit" value="Cambio Base">
        <input type="reset" value="Borrar">
    </form>
</body>
</html>