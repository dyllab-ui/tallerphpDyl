<?php
require_once __DIR__ . '/../clases/ConversorBinario.php';

$base     = '../';
$titulo   = 'Decimal a binario';
$numero   = '';
$error    = '';
$conversor = null;
$binario  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');
    $n = filter_var($numero, FILTER_VALIDATE_INT);

    if ($n === false) {
        $error = 'Ingrese un número entero válido.';
    } else {
        $conversor = new ConversorBinario($n);
        $binario   = $conversor->convertir();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="tarjeta">
    <h2>5. Convertir un número entero a binario</h2>

    <form method="post" action="5_binario.php">
        <label for="numero">Número entero</label>
        <input type="number" id="numero" name="numero" value="<?= e($numero) ?>" required>
        <button type="submit">Convertir</button>
    </form>

    <?php if ($error !== ''): ?>
        <p class="error"><?= e($error) ?></p>
    <?php elseif ($binario !== null): ?>
        <div class="resultado">
            <p><?= e($numero) ?> en binario es:</p>
            <p class="grande"><?= e($binario) ?></p>

            <?php if (count($conversor->pasos()) > 0): ?>
                <p>Divisiones sucesivas entre 2 (el binario se lee de abajo hacia arriba en la columna de residuos):</p>
                <table>
                    <tr><th>Dividendo</th><th>Cociente</th><th>Residuo</th></tr>
                    <?php foreach ($conversor->pasos() as $paso): ?>
                        <tr><td><?= $paso['dividendo'] ?></td><td><?= $paso['cociente'] ?></td><td><?= $paso['residuo'] ?></td></tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
