<?php
require_once __DIR__ . '/../config/conexion_banco.php';
require_once __DIR__ . '/auditoria.php';

class clsTransferencias
{
    public static function ejecutarTransaccion($origen, $destino, $monto)
    {
        session_start();

        $conexion = conexionBD::conectar();

        try
        {
            if ($origen == $destino)
            {
                throw new Exception("No puede transferir a la misma cuenta");
            }

            $conexion->begin_transaction();

            $cuentaOrigen = $conexion->query("SELECT * FROM cuentas WHERE id=$origen")->fetch_assoc();

            $cuentaDestino = $conexion->query("SELECT * FROM cuentas WHERE id=$destino")->fetch_assoc();

            if (!$cuentaOrigen || !$cuentaDestino)
            {
                throw new Exception("Cuenta inválida");
            }

            if ($cuentaOrigen['saldo'] < $monto)
            {
                throw new Exception("Saldo insuficiente");
            }

            $antesOrigen = $cuentaOrigen;
            $antesDestino = $cuentaDestino;

            $conexion->query("UPDATE cuentas SET saldo = saldo - $monto WHERE id=$origen");

            $conexion->query("UPDATE cuentas SET saldo = saldo + $monto WHERE id=$destino");

            $despuesOrigen = $conexion->query("SELECT * FROM cuentas WHERE id=$origen")->fetch_assoc();

            $despuesDestino = $conexion->query("SELECT * FROM cuentas WHERE id=$destino")->fetch_assoc();

            clsAuditoria::registrarTransaccion(
                $conexion,
                $_SESSION['usuario'],
                $_SESSION['rol'],
                "Transferencia",
                "cuentas",
                $origen,
                $antesOrigen,
                $despuesOrigen,
                "EXITO"
            );

            clsAuditoria::registrarTransaccion(
                $conexion,
                $_SESSION['usuario'],
                $_SESSION['rol'],
                "Transferencia",
                "cuentas",
                $destino,
                $antesDestino,
                $despuesDestino,
                "EXITO"
            );

            $conexion->commit();

            return "Transferencia realizada con éxito";
        }
        catch (Exception $e)
        {
            $conexion->rollback();

            clsAuditoria::registrarTransaccion(
                $conexion,
                $_SESSION['usuario'],
                $_SESSION['rol'],
                "Transferencia",
                "cuentas",
                null,
                null,
                null,
                "ERROR",
                $e->getMessage()
            );

            return $e->getMessage();
        }
    }

    public static function movimiento($cuenta, $tipo, $monto)
    {
        session_start();

        $conexion = conexionBD::conectar();

        try
        {
            $datos = $conexion->query("SELECT * FROM cuentas WHERE id=$cuenta")->fetch_assoc();

            if (!$datos)
            {
                throw new Exception("Cuenta inválida");
            }

            $antes = $datos;

            if ($tipo == "retiro")
            {
                if ($datos['saldo'] < $monto)
                {
                    throw new Exception("Saldo insuficiente");
                }

                $conexion->query("UPDATE cuentas SET saldo = saldo - $monto WHERE id=$cuenta");
            }
            else
            {
                $conexion->query("UPDATE cuentas SET saldo = saldo + $monto WHERE id=$cuenta");
            }

            $despues = $conexion->query("SELECT * FROM cuentas WHERE id=$cuenta")->fetch_assoc();

            clsAuditoria::registrarTransaccion(
                $conexion,
                $_SESSION['usuario'],
                $_SESSION['rol'],
                strtoupper($tipo),
                "cuentas",
                $cuenta,
                $antes,
                $despues,
                "EXITO"
            );

            return "Operación realizada con éxito";
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }
}
?>