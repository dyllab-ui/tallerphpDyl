<?php
require_once __DIR__ . '/../clases.php';

$base = '../';
$titulo = 'Fibonacci y factorial';
$numero = '';
$operacion = 'fibonacci';
$secuencia = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');
    $operacion = $_POST['operacion'] ?? 'fibonacci';
    $n = filter_var($numero, FILTER_VALIDATE_INT);

    if ($n === false) {
        $error = 'Ingresa un número entero válido.';
    } else {
        try {
            if ($operacion === 'factorial') {
                $secuencia = new Factorial($n);
            } else {
                $secuencia = new Fibonacci($n);
            }
        } catch (InvalidArgumentException $ex) {
            $error = $ex->getMessage();
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="mesa">
    <section class="panel">
        <h3 class="panel-titulo">Datos de entrada</h3>
        <form method="post" action="2_secuencias.php">
            <label for="numero">Número</label>
            <input type="number" id="numero" name="numero" value="<?= e($numero) ?>" required>

            <label>Operación</label>
            <div class="opciones">
                <label><input type="radio" name="operacion" value="fibonacci" <?= $operacion !== 'factorial' ? 'checked' : '' ?>> Sucesión de Fibonacci</label>
                <label><input type="radio" name="operacion" value="factorial" <?= $operacion === 'factorial' ? 'checked' : '' ?>> Factorial</label>
            </div>
            <p class="ayuda">Fibonacci muestra de <?= Fibonacci::MINIMO ?> a <?= Fibonacci::MAXIMO ?> términos. El factorial acepta de <?= Factorial::MINIMO ?> a <?= Factorial::MAXIMO ?>.</p>
            <button type="submit">Calcular</button>
        </form>
    </section>
    <section class="panel panel-salida">
        <h3 class="panel-titulo">Resultado</h3>
        <?php if ($error !== ''): ?>
            <p class="error"><?= e($error) ?></p>
        <?php elseif ($secuencia instanceof Fibonacci): ?>
            <p class="etiqueta"><?= e($secuencia->titulo()) ?></p>
            <div class="fichas">
                <?php foreach ($secuencia->serie() as $valor): ?>
                    <span class="ficha"><?= $valor ?></span>
                <?php endforeach; ?>
            </div>
        <?php elseif ($secuencia instanceof Factorial): ?>
            <p class="etiqueta"><?= e($secuencia->titulo()) ?></p>
            <p class="grande"><?= $secuencia->resultado() ?></p>
            <div class="tabla-scroll">
                <table>
                    <tr><th>n</th><th>n!</th></tr>
                    <?php foreach ($secuencia->serie() as $i => $valor): ?>
                        <tr><td><?= $i ?></td><td><?= $valor ?></td></tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php else: ?>
            <p class="espera">Aquí aparecerá la serie.</p>
        <?php endif; ?>
    </section>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
