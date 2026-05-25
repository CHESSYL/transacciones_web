<?php
session_start();

require_once __DIR__ . '/../config/conexion_banco.php';

$conexion = conexionBD::conectar();

if ($_SESSION['rol'] == 'cliente')
{
    $usuario = $_SESSION['usuario'];

    $stmt = $conexion->prepare(
        "SELECT * FROM auditoria
        WHERE usuario = ?
        ORDER BY fecha DESC"
    );

    $stmt->bind_param("s", $usuario);
    $stmt->execute();

    $resultado = $stmt->get_result();
}
else
{
    $resultado = $conexion->query(
        "SELECT * FROM auditoria ORDER BY fecha DESC"
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

        <h2>Auditoría</h2>

        <table class="table">

            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Proceso</th>
                <th>Resultado</th>
                <th>Mensaje</th>
            </tr>

            <?php while($row = $resultado->fetch_assoc()): ?>

            <tr>

                <td><?= $row['fecha'] ?></td>

                <td><?= $row['usuario'] ?></td>

                <td><?= $row['rol'] ?></td>

                <td><?= $row['proceso'] ?></td>

                <td class="<?= $row['resultado'] == 'EXITO' ? 'success' : 'error' ?>">
                    <?= $row['resultado'] ?>
                </td>

                <td><?= $row['mensaje'] ?></td>

            </tr>

            <?php endwhile; ?>

        </table>

        <a href="index.php">Volver</a>

    </div>

</div>

</body>
</html>