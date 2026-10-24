<?php
$base = '';
$titulo = 'Inicio';
require_once __DIR__ . '/includes/header.php';
$indice = 0;
?>
<section class="bienvenida-aero">
    <p class="sobrelinea">Dylan Antonio Rueda Rocha</p>
    <h2> Taller php</h2>
    <p>Elige una burbuja y explora una de las 7 aplicaciones.</p>
</section>
<section class="orbita-menu" aria-label="Estaciones del laboratorio">
    <span class="luna luna-1"></span>
    <span class="luna luna-2"></span>
    <span class="luna luna-3"></span>
    <span class="planeta-deco planeta-a"></span>
    <span class="planeta-deco planeta-b"></span>
    <span class="destello destello-1">✦</span>
    <span class="destello destello-2">✧</span>
    <span class="destello destello-3">✦</span>
    <span class="destello destello-4">✧</span>
    <div class="burbuja-central">
        <span class="brillo-central">✧</span>
        <strong>PHP</strong>
    </div>
    <?php foreach ($estaciones as $archivo => $datos): $indice++; ?>
        <a class="burbuja-opcion opcion-<?= $indice ?>" href="operaciones/<?= e($archivo) ?>">
            <span class="burbuja-icono"><?= e($datos['icono']) ?></span>
            <strong><?= e($datos['nombre']) ?></strong>
            <small><?= e($datos['resumen']) ?></small>
        </a>
    <?php endforeach; ?>
</section>
<p class="nota-orbita">Siete aplicaciones · en un solo lugar</p>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
