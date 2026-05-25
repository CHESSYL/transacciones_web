<?php
class clsAuditoria
{
    public static function registrarTransaccion(
        $conexion,
        $usuario,
        $rol,
        $proceso,
        $tabla,
        $id,
        $antes,
        $despues,
        $resultado,
        $mensaje = null
    )
    {
        $sql = "INSERT INTO auditoria
        (
            usuario,
            rol,
            proceso,
            tabla_afectada,
            registro_id,
            datos_antes,
            datos_despues,
            resultado,
            mensaje
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param(
            "ssssissss",
            $usuario,
            $rol,
            $proceso,
            $tabla,
            $id,
            json_encode($antes),
            json_encode($despues),
            $resultado,
            $mensaje
        );

        $stmt->execute();
    }
}
?>