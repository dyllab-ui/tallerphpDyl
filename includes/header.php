<?php
require_once __DIR__ . '/funciones.php';

if (!isset($base)) {
    $base = '';
}
if (!isset($titulo)) {
    $titulo = 'Taller PHP';
}

$paginaActual = basename($_SERVER['SCRIPT_NAME']);
$estaciones = estaciones();
$estacionActual = isset($estaciones[$paginaActual]) ? $estaciones[$paginaActual] : null;
$posicionEstacion = 0;
$estiloPagina = '';

if ($estacionActual !== null) {
    $posicionEstacion = array_search($paginaActual, array_keys($estaciones)) + 1;
    $estiloPagina = ' style="--acento: ' . $estacionActual['acento'] . '; --resplandor: ' . $estacionActual['brillo'] . ';"';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?> | Taller PHP</title>
    <link rel="stylesheet" href="<?= $base ?>css/estilo.css">
</head>
<body class="<?= $estacionActual !== null ? 'pagina-estacion' : 'pagina-inicio' ?>"<?= $estiloPagina ?>>
<div class="cielo" aria-hidden="true">
    <span class="cometa cometa-1"></span>
    <span class="cometa cometa-2"></span>
    <span class="cometa cometa-3"></span>
</div>
<div class="burbujas" aria-hidden="true">
    <i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i>
</div>
<header class="cabecera">
    <a class="marca" href="<?= $base ?>index.php">
        <span class="mini-planeta"></span>
        <span class="marca-texto">
            <strong>Taller PHP</strong>
        </span>
    </a>
    <nav class="menu" aria-label="Estaciones">
        <?php foreach ($estaciones as $archivo => $datos): ?>
            <a href="<?= $base ?>operaciones/<?= e($archivo) ?>" class="<?= $paginaActual === $archivo ? 'activo' : '' ?>" style="--p: <?= $datos['acento'] ?>">
                <span class="punto"></span><?= e($datos['nombre']) ?>
            </a>
        <?php endforeach; ?>
    </nav>
</header>
<main class="contenido">
<?php if ($estacionActual !== null): ?>
    <section class="estacion-cabeza">
        <span class="estacion-icono"><?= e($estacionActual['icono']) ?></span>
        <div>
            <p class="estacion-n">ESTACIÓN <?= $posicionEstacion ?> DE <?= count($estaciones) ?></p>
            <h2><?= e($estacionActual['titulo']) ?></h2>
            <p class="estacion-desc"><?= e($estacionActual['descripcion']) ?></p>
        </div>
    </section>
<?php endif; ?>
