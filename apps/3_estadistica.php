<?php
require_once __DIR__ . '/../clases/Estadistica.php';

$base     = '../';
$titulo   = 'Promedio, mediana y moda';
$cantidad = filter_var($_POST['cantidad'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 50]]);
$valores  = (isset($_POST['num']) && is_array($_POST['num'])) ? $_POST['num'] : null;
$error    = '';
$stats    = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($cantidad === false) {
        $error = 'Ingrese una cantidad entera entre 1 y 50.';
    } elseif ($valores !== null) {
        $numeros = [];
        foreach ($valores as $v) {
            $v = str_replace(',', '.', trim((string) $v));
            if (!is_numeric($v)) {
                $error = 'Todos los valores deben ser números válidos.';
                break;
            }
            $numeros[] = (float) $v;
        }
        if ($error === '') {
            $stats = new Estadistica($numeros);
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="tarjeta">
    <h2>3. Promedio, mediana y moda</h2>
    <p>Primero indique cuántos números va a ingresar y luego escríbalos.</p>
    <p><small>El promedio es la media aritmética; se agrega también la mediana (valor central).</small></p>

    <?php if ($error !== ''): ?>
        <p class="error"><?= e($error) ?></p>
    <?php endif; ?>

    <?php if ($cantidad === false || $cantidad === null): ?>
        <!-- Paso 1: cantidad de números -->
        <form method="post" action="3_estadistica.php">
            <label for="cantidad">¿Cuántos números va a ingresar?</label>
            <input type="number" id="cantidad" name="cantidad" min="1" max="50" required>
            <button type="submit">Continuar</button>
        </form>
    <?php else: ?>
        <!-- Paso 2: los números -->
        <form method="post" action="3_estadistica.php">
            <input type="hidden" name="cantidad" value="<?= $cantidad ?>">
            <div class="fila">
                <?php for ($i = 0; $i < $cantidad; $i++): ?>
                    <div>
                        <label for="num<?= $i ?>">Número <?= $i + 1 ?></label>
                        <input type="number" step="any" id="num<?= $i ?>" name="num[]"
                               value="<?= e((string) ($valores[$i] ?? '')) ?>" required>
                    </div>
                <?php endfor; ?>
            </div>
            <button type="submit">Calcular</button>
            <a class="boton" href="3_estadistica.php">Cambiar cantidad</a>
        </form>
    <?php endif; ?>

    <?php if ($stats !== null): ?>
        <?php $modas = $stats->moda(); ?>
        <div class="resultado">
            <p><strong>Cantidad de números:</strong> <?= $stats->cantidad() ?></p>
            <p><strong>Promedio (media):</strong> <?= e(formatearNumero($stats->promedio())) ?></p>
            <p><strong>Mediana:</strong> <?= e(formatearNumero($stats->mediana())) ?></p>
            <p><strong>Moda:</strong>
                <?= count($modas) === 0
                    ? 'No hay moda (ningún valor se repite)'
                    : e(implode(', ', array_map('formatearNumero', $modas))) ?>
            </p>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
