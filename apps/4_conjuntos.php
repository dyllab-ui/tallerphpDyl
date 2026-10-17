<?php
require_once __DIR__ . '/../clases/Conjunto.php';

$base   = '../';
$titulo = 'Conjuntos';
$textoA = '';
$textoB = '';
$error  = '';
$A = $B = null;

/** Convierte "1, 2, 3" en [1,2,3] validando que sean enteros. */
function leerConjunto(string $texto, string $nombre): array
{
    $partes = preg_split('/[\s,;]+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
    $numeros = [];
    foreach ($partes as $p) {
        if (filter_var($p, FILTER_VALIDATE_INT) === false) {
            throw new InvalidArgumentException("El conjunto $nombre solo puede tener números enteros (error en \"$p\").");
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
        $A = $B = null;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="tarjeta">
    <h2>4. Operaciones entre conjuntos</h2>
    <p>Escriba los números enteros de cada conjunto separados por comas o espacios. Ejemplo: <code>1, 2, 3, 4</code></p>

    <form method="post" action="4_conjuntos.php">
        <label for="conjuntoA">Conjunto A</label>
        <input type="text" id="conjuntoA" name="conjuntoA" value="<?= e($textoA) ?>" required>

        <label for="conjuntoB">Conjunto B</label>
        <input type="text" id="conjuntoB" name="conjuntoB" value="<?= e($textoB) ?>" required>

        <button type="submit">Calcular</button>
    </form>

    <?php if ($error !== ''): ?>
        <p class="error"><?= e($error) ?></p>
    <?php elseif ($A !== null && $B !== null): ?>
        <div class="resultado">
            <p><strong>A</strong> = <?= e((string) $A) ?></p>
            <p><strong>B</strong> = <?= e((string) $B) ?></p>
            <p><strong>A ∪ B (unión)</strong> = <?= e((string) $A->union($B)) ?></p>
            <p><strong>A ∩ B (intersección)</strong> = <?= e((string) $A->interseccion($B)) ?></p>
            <p><strong>A − B</strong> = <?= e((string) $A->diferencia($B)) ?></p>
            <p><strong>B − A</strong> = <?= e((string) $B->diferencia($A)) ?></p>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
