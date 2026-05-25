<?php
class conexionBD
{
    public static function conectar()
    {
        $conexion = new mysqli("localhost", "root", "chelseapaola19", "transacciones_web");

        if ($conexion->connect_error)
        {
            die("Error: " . $conexion->connect_error);
        }

        $conexion->set_charset("utf8mb4");

        return $conexion;
    }
}
?>