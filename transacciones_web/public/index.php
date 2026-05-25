<?php
session_start();

if (!isset($_SESSION['usuario']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transferencias bien chidas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="header">
    <h1>Sistema de Transferencias</h1>
</div>

<div class="container">

    <div class="card">

        <h2>Bienvenido <?= $_SESSION['usuario'] ?></h2>
        <h2>Realizar Transferencia</h2>

        <form method="POST" action="procesar_transferencia.php"
        onsubmit="return confirm('¿Desea realizar esta transferencia?')">

            <?php if($_SESSION['rol'] == 'empleado'): ?>

                <label>Cuenta Origen</label>
                <input type="number" name="origen" required>

            <?php else: ?>

                <input type="hidden" name="origen" value="<?= $_SESSION['cuenta_id'] ?>">

            <?php endif; ?>

            <label>Cuenta Destino</label>
            <input type="number" name="destino" required>

            <label>Monto</label>
            <input type="number" name="monto" step="0.01" required>

            <button type="submit">Transferir</button>

        </form>

    </div>

    <div class="card">

        <h2>Movimientos</h2>

        <form method="POST" action="procesar_movimiento.php"
        onsubmit="return confirm('¿Desea realizar esta operación?')">

            <?php if($_SESSION['rol'] == 'empleado'): ?>

                <label>Cuenta</label>
                <input type="number" name="cuenta" required>

            <?php else: ?>

                <input type="hidden" name="cuenta" value="<?= $_SESSION['cuenta_id'] ?>">

            <?php endif; ?>

            <label>Tipo</label>

            <select name="tipo">
                <option value="deposito">Depósito</option>
                <option value="retiro">Retiro</option>
            </select>

            <label>Monto</label>
            <input type="number" name="monto" step="0.01" required>

            <button type="submit">Procesar</button>

        </form>

    </div>

    <div class="card">
        <a href="datos_cuentas.php">Ver cuentas</a><br><br>
        <a href="datos_auditoria.php">Ver auditoría</a><br><br>
        <a href="logout.php">Cerrar sesión</a>
    </div>

</div>

</body>
</html>