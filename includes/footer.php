<?php
$estacionAnterior = null;
$estacionSiguiente = null;

if ($estacionActual !== null) {
    $archivos = array_keys($estaciones);
    if ($posicionEstacion > 1) {
        $estacionAnterior = $archivos[$posicionEstacion - 2];
    }
    if ($posicionEstacion < count($archivos)) {
        $estacionSiguiente = $archivos[$posicionEstacion];
    }
}
?>
<?php if ($estacionActual !== null): ?>
    <nav class="pasos" aria-label="Cambiar de estación">
        <?php if ($estacionAnterior !== null): ?>
            <a class="paso" href="<?= e($estacionAnterior) ?>">← <?= e($estaciones[$estacionAnterior]['nombre']) ?></a>
        <?php else: ?>
            <span></span>
        <?php endif; ?>
        <a class="paso paso-centro" href="<?= $base ?>index.php">Volver a la órbita</a>
        <?php if ($estacionSiguiente !== null): ?>
            <a class="paso" href="<?= e($estacionSiguiente) ?>"><?= e($estaciones[$estacionSiguiente]['nombre']) ?> →</a>
        <?php else: ?>
            <span></span>
        <?php endif; ?>
    </nav>
<?php endif; ?>
</main>
<footer class="pie">
    <p>Laboratorio PHP &middot; HTML, CSS, PHP y POO</p>
</footer>
</body>
</html>
