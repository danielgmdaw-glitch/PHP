<?php
session_start();

if (!isset($_SESSION['nif']) || empty($_SESSION['nif'])) {
    header("Location: comlogincli.php");
    exit;
}

$nif = $_SESSION['nif'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal del Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 50px auto;
            text-align: center;
            background: #f4f6f9;
        }
        h1 { color: #2c3e50; }
        .bienvenida { font-size: 1.3em; margin: 30px 0; color: #34495e; }
        .menu {
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 400px;
            margin: 0 auto;
        }
        .btn {
            background: #3498db;
            color: white;
            padding: 18px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 1.2em;
            transition: background 0.2s;
        }
        .btn:hover { background: #2980b9; }
        .btn.logout {
            background: #e74c3c;
        }
        .btn.logout:hover { background: #c0392b; }
    </style>
</head>
<body>

    <h1>¡Bienvenido al Portal de Compras!</h1>
    <div class="bienvenida">Estás conectado como cliente NIF: <strong><?= htmlspecialchars($nif) ?></strong></div>

    <div class="menu">
        <a href="../ejercicio12/comprocli.php" class="btn">Comprar productos</a>
        <a href="../ejercicio13/comconscli.php" class="btn">Consultar mis compras</a>
        <a href="logout.php" class="btn logout">Cerrar sesión</a>
    </div>
</body>
</html>