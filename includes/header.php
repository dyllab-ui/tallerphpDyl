<?php
require_once __DIR__ . '/funciones.php';
$base   = $base ?? '';            // Ruta relativa hacia la raíz del proyecto
$titulo = $titulo ?? 'Taller PHP';
$actual = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?> | Taller PHP</title>
    <link rel="stylesheet" href="<?= $base ?>css/estilo.css">
</head>
<body>
<header class="cabecera">
    <h1>Taller PHP</h1>
    <nav class="menu">
        <a href="<?= $base ?>index.php" class="<?= $actual === 'index.php' ? 'activo' : '' ?>">Inicio</a>
        <?php foreach (menuAplicaciones() as $archivo => $nombre): ?>
            <a href="<?= $base ?>apps/<?= $archivo ?>" class="<?= $actual === $archivo ? 'activo' : '' ?>"><?= e($nombre) ?></a>
        <?php endforeach; ?>
    </nav>
</header>
<main class="contenido">
