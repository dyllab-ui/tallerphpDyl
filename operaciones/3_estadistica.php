<?php
require_once __DIR__ . '/../clases.php';

$base = '../';
$titulo = 'Promedio, mediana y moda';
$cantidad = filter_var(
    isset($_POST['cantidad']) ? $_POST['cantidad'] : null,
    FILTER_VALIDATE_INT,
    array('options' => array('min_range' => 1, 'max_range' => 50))
);
$valores = (isset($_POST['num']) && is_array($_POST['num'])) ? $_POST['num'] : null;
$error = '';
$stats = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($cantidad === false) {
        $error = 'Ingresa una cantidad entera entre 1 y 50.';
    } elseif ($valores !== null) {
        $numeros = array();
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
<div class="mesa">
    <section class="panel">
        <h3 class="panel-titulo">Datos de entrada</h3>
        <?php if ($cantidad === false): ?>
            <p class="ayuda">Primero indica cuántos números vas a ingresar.</p>
            <form method="post" action="3_estadistica.php">
                <label for="cantidad">¿Cuántos números?</label>
                <input type="number" id="cantidad" name="cantidad" min="1" max="50" required>
                <button type="submit">Continuar</button>
            </form>
        <?php else: ?>
            <form method="post" action="3_estadistica.php">
                <input type="hidden" name="cantidad" value="<?= $cantidad ?>">
                <div class="fila">
                    <?php for ($i = 0; $i < $cantidad; $i++): ?>
                        <div>
                            <label for="num<?= $i ?>">Número <?= $i + 1 ?></label>
                            <input type="number" step="any" id="num<?= $i ?>" name="num[]" value="<?= e(isset($valores[$i]) ? $valores[$i] : '') ?>" required>
                        </div>
                    <?php endfor; ?>
                </div>
                <button type="submit">Calcular</button>
                <a class="boton boton-suave" href="3_estadistica.php">Cambiar cantidad</a>
            </form>
        <?php endif; ?>
    </section>
    <section class="panel panel-salida">
        <h3 class="panel-titulo">Resultado</h3>
        <?php if ($error !== ''): ?>
            <p class="error"><?= e($error) ?></p>
        <?php elseif ($stats !== null): ?>
            <?php $modas = $stats->moda(); ?>
            <div class="cifras">
                <div class="cifra"><span>Cantidad</span><strong><?= $stats->cantidad() ?></strong></div>
                <div class="cifra"><span>Promedio</span><strong><?= e(formatearNumero($stats->promedio())) ?></strong></div>
                <div class="cifra"><span>Mediana</span><strong><?= e(formatearNumero($stats->mediana())) ?></strong></div>
                <div class="cifra">
                    <span>Moda</span>
                    <strong><?= count($modas) === 0 ? 'Sin moda' : e(implode(', ', array_map('formatearNumero', $modas))) ?></strong>
                </div>
            </div>
        <?php else: ?>
            <p class="espera">Aquí aparecerán las medidas.</p>
        <?php endif; ?>
    </section>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
