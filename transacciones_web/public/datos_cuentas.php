<?php
session_start();

require_once __DIR__ . '/../config/conexion_banco.php';

$conexion = conexionBD::conectar();

if ($_SESSION['rol'] == 'cliente')
{
    $id = $_SESSION['cuenta_id'];

    $resultado = $conexion->query(
        "SELECT * FROM cuentas WHERE id = $id"
    );
}
else
{
    $resultado = $conexion->query(
        "SELECT * FROM cuentas"
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">

    <div class="card">

        <h2>Cuentas</h2>

        <table class="table">

            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Saldo</th>
            </tr>

            <?php while($row = $resultado->fetch_assoc()): ?>

            <tr>

                <td><?= $row['id'] ?></td>
                <td><?= $row['nombre'] ?></td>
                <td>$<?= $row['saldo'] ?></td>

            </tr>

            <?php endwhile; ?>

        </table>

        <a href="index.php">Volver</a>

    </div>

</div>

</body>
</html>