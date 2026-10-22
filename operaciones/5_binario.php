<?php
require_once __DIR__ . '/../clases.php';

$base = '../';
$titulo = 'Decimal a binario';
$numero = '';
$error = '';
$conversor = null;
$binario = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');
    $n = filter_var($numero, FILTER_VALIDATE_INT);

    if ($n === false) {
        $error = 'Ingresa un número entero válido.';
    } else {
        $conversor = new ConversorBinario($n);
        $binario = $conversor->convertir();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="mesa">
    <section class="panel">
        <h3 class="panel-titulo">Número de entrada</h3>
        <form method="post" action="5_binario.php">
            <label for="numero">Número entero</label>
            <input type="number" id="numero" name="numero" value="<?= e($numero) ?>" placeholder="25" required>
            <button type="submit">Convertir</button>
        </form>
    </section>
    <section class="panel panel-salida">
        <h3 class="panel-titulo">Resultado</h3>
        <?php if ($error !== ''): ?>
            <p class="error"><?= e($error) ?></p>
        <?php elseif ($binario !== null): ?>
            <p class="etiqueta"><?= e($numero) ?> en binario</p>
            <p class="grande"><?= e($binario) ?></p>
            <?php if (count($conversor->pasos()) > 0): ?>
                <p class="ayuda">Divisiones sucesivas entre 2. El binario se lee de abajo hacia arriba en la columna de residuos.</p>
                <div class="tabla-scroll">
                    <table>
                        <tr><th>Dividendo</th><th>Cociente</th><th>Residuo</th></tr>
                        <?php foreach ($conversor->pasos() as $paso): ?>
                            <tr><td><?= $paso['dividendo'] ?></td><td><?= $paso['cociente'] ?></td><td><?= $paso['residuo'] ?></td></tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p class="espera">Aquí aparecerá el número en binario.</p>
        <?php endif; ?>
    </section>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
