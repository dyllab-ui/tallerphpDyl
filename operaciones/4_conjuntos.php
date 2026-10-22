<?php
require_once __DIR__ . '/../clases.php';

$base = '../';
$titulo = 'Conjuntos';
$textoA = '';
$textoB = '';
$error = '';
$A = null;
$B = null;

function leerConjunto($texto, $nombre)
{
    $partes = preg_split('/[\s,;]+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
    $numeros = array();

    foreach ($partes as $p) {
        if (filter_var($p, FILTER_VALIDATE_INT) === false) {
            throw new InvalidArgumentException('El conjunto ' . $nombre . ' solo admite números enteros (revisa «' . $p . '»).');
        }
        $numeros[] = (int) $p;
    }

    return $numeros;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $textoA = $_POST['conjuntoA'] ?? '';
    $textoB = $_POST['conjuntoB'] ?? '';

    try {
        $A = new Conjunto(leerConjunto($textoA, 'A'));
        $B = new Conjunto(leerConjunto($textoB, 'B'));
    } catch (InvalidArgumentException $ex) {
        $error = $ex->getMessage();
        $A = null;
        $B = null;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="mesa">
    <section class="panel">
        <h3 class="panel-titulo">Conjuntos de entrada</h3>
        <p class="ayuda">Escribe números enteros separados por comas o espacios. Ejemplo: 1, 2, 3, 4</p>
        <form method="post" action="4_conjuntos.php">
            <label for="conjuntoA">Conjunto A</label>
            <input type="text" id="conjuntoA" name="conjuntoA" value="<?= e($textoA) ?>" placeholder="1, 2, 3, 4" required>

            <label for="conjuntoB">Conjunto B</label>
            <input type="text" id="conjuntoB" name="conjuntoB" value="<?= e($textoB) ?>" placeholder="3, 4, 5, 6" required>

            <button type="submit">Calcular</button>
        </form>
    </section>
    <section class="panel panel-salida">
        <h3 class="panel-titulo">Resultado</h3>
        <?php if ($error !== ''): ?>
            <p class="error"><?= e($error) ?></p>
        <?php elseif ($A !== null && $B !== null): ?>
            <div class="cifras una">
                <div class="cifra"><span>A</span><strong><?= e($A) ?></strong></div>
                <div class="cifra"><span>B</span><strong><?= e($B) ?></strong></div>
                <div class="cifra"><span>Unión (A ∪ B)</span><strong><?= e($A->union($B)) ?></strong></div>
                <div class="cifra"><span>Intersección (A ∩ B)</span><strong><?= e($A->interseccion($B)) ?></strong></div>
                <div class="cifra"><span>Diferencia (A − B)</span><strong><?= e($A->diferencia($B)) ?></strong></div>
                <div class="cifra"><span>Diferencia (B − A)</span><strong><?= e($B->diferencia($A)) ?></strong></div>
            </div>
        <?php else: ?>
            <p class="espera">Aquí aparecerán las operaciones.</p>
        <?php endif; ?>
    </section>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
