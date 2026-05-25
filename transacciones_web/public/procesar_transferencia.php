<?php
session_start();

require_once __DIR__ . '/../servicios/transferencias.php';

$resultado = clsTransferencias::ejecutarTransaccion(
    $_POST['origen'],
    $_POST['destino'],
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

        <p class="<?= strpos($resultado, 'éxito') !== false ? 'success' : 'error' ?>">
            <?= $resultado ?>
        </p>

        <a href="index.php">Volver</a>

    </div>

</div>

</body>
</html>