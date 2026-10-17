<?php
/**
 * Guarda el historial de operaciones en la sesión del usuario.
 * (Requiere haber llamado a session_start() antes.)
 */
class Historial
{
    private const CLAVE = 'historial_calculadora';

    public function __construct()
    {
        if (!isset($_SESSION[self::CLAVE])) {
            $_SESSION[self::CLAVE] = [];
        }
    }

    public function agregar(string $operacion): void
    {
        // La más reciente queda de primera
        array_unshift($_SESSION[self::CLAVE], $operacion);
    }

    public function obtener(): array
    {
        return $_SESSION[self::CLAVE];
    }

    public function borrar(): void
    {
        $_SESSION[self::CLAVE] = [];
    }
}
