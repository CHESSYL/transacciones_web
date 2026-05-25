<?php
session_start();
require_once __DIR__ . '/../config/conexion_banco.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $conexion = conexionBD::conectar();

    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $clave);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0)
    {
        $datos = $resultado->fetch_assoc();

        $_SESSION['usuario'] = $datos['usuario'];
        $_SESSION['rol'] = $datos['rol'];
        $_SESSION['cuenta_id'] = $datos['cuenta_id'];

        header("Location: index.php");
        exit();
    }
    else
    {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login bien chido</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <div class="card">

        <h2>Te damos la bienvenida🍁</h2>

        <form method="POST">

            <label>Usuario</label>
            <input type="text" name="usuario" required>

            <label>Contraseña</label>
            <input type="password" name="clave" required>

            <button type="submit">Ingresar</button>

        </form>

        <p class="error"><?= $error ?></p>

    </div>
</div>

</body>
</html>