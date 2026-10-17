<?php
require_once __DIR__ . '/../clases/Secuencias.php';

$base      = '../';
$titulo    = 'Fibonacci / Factorial';
$numero    = '';
$operacion = 'fibonacci';
$secuencia = null;
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero    = trim($_POST['numero'] ?? '');
    $operacion = $_POST['operacion'] ?? 'fibonacci';
    $n = filter_var($numero, FILTER_VALIDATE_INT);

    if ($n === false) {
        $error = 'Ingrese un número entero válido.';
    } else {
        try {
            $secuencia = ($operacion === 'factorial') ? new Factorial($n) : new Fibonacci($n);
        } catch (InvalidArgumentException $ex) {
            $error = $ex->getMessage();
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="tarjeta">
    <h2>2. Sucesión de Fibonacci o factorial</h2>

    <form method="post" action="2_secuencias.php">
        <label for="numero">Número</label>
        <input type="number" id="numero" name="numero" value="<?= e($numero) ?>" required>

        <label>Operación</label>
        <div class="opciones">
            <label><input type="radio" name="operacion" value="fibonacci" <?= $operacion !== 'factorial' ? 'checked' : '' ?>> Sucesión de Fibonacci</label>
            <label><input type="radio" name="operacion" value="factorial" <?= $operacion === 'factorial' ? 'checked' : '' ?>> Factorial</label>
        </div>
        <p><small>Fibonacci: entre 1 y <?= Fibonacci::MAXIMO ?> términos. Factorial: entre 0 y <?= Factorial::MAXIMO ?>.</small></p>
        <button type="submit">Calcular</button>
    </form>

    <?php if ($error !== ''): ?>
        <p class="error"><?= e($error) ?></p>
    <?php elseif ($secuencia instanceof Fibonacci): ?>
        <div class="resultado">
            <p><strong><?= e($secuencia->titulo()) ?></strong></p>
            <p class="grande"><?= e(implode(', ', $secuencia->serie())) ?></p>
        </div>
    <?php elseif ($secuencia instanceof Factorial): ?>
        <div class="resultado">
            <p><strong><?= e($secuencia->titulo()) ?> = <?= $secuencia->resultado() ?></strong></p>
            <table>
                <tr><th>n</th><th>n!</th></tr>
                <?php foreach ($secuencia->serie() as $i => $valor): ?>
                    <tr><td><?= $i ?></td><td><?= $valor ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
