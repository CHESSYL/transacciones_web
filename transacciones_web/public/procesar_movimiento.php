<?php
session_start();

require_once __DIR__ . '/../servicios/transferencias.php';

$resultado = clsTransferencias::movimiento(
    $_POST['cuenta'],
    $_POST['tipo'],
    $_POST['monto']
);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <div class="card">

        <h2>Resultado</h2>

        <p><?= $resultado ?></p>

        <a href="index.php">Volver</a>

    </div>
</div>

</body>
</html>