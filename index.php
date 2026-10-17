<?php
$base   = '';
$titulo = 'Inicio';
require_once __DIR__ . '/includes/header.php';

$descripciones = [
    '1_acronimo.php'    => 'Convierte una frase en su acrónimo.',
    '2_secuencias.php'  => 'Genera la serie de Fibonacci o de factoriales.',
    '3_estadistica.php' => 'Promedio, mediana y moda de una serie de números.',
    '4_conjuntos.php'   => 'Unión, intersección y diferencias de dos conjuntos.',
    '5_binario.php'     => 'Convierte un número entero a binario.',
    '6_arbol.php'       => 'Construye un árbol binario desde sus recorridos.',
    '7_calculadora.php' => 'Calculadora con historial de operaciones.',
];
?>
<div class="tarjeta">
    <h2>Bienvenido</h2>
    <p>Elige una de las aplicaciones del taller en el menú de arriba o en las tarjetas de abajo.</p>
</div>

<div class="rejilla">
    <?php foreach (menuAplicaciones() as $archivo => $nombre): ?>
        <a href="apps/<?= $archivo ?>">
            <strong><?= e($nombre) ?></strong>
            <span><?= e($descripciones[$archivo]) ?></span>
        </a>
    <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
