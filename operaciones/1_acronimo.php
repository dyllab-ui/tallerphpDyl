<?php
require_once __DIR__ . '/../clases.php';

$base = '../';
$titulo = 'Acrónimo';
$frase = '';
$siglas = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = trim($_POST['frase'] ?? '');

    if ($frase === '') {
        $error = 'Escribe una frase.';
    } else {
        try {
            $acronimo = new Acronimo($frase);
            $siglas = $acronimo->generar();
            if ($siglas === '') {
                $siglas = null;
                $error = 'La frase no tiene palabras válidas.';
            }
        } catch (Exception $ex) {
            $error = $ex->getMessage();
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="mesa">
    <section class="panel">
        <h3 class="panel-titulo">Frase de entrada</h3>
        <p class="ayuda">Los guiones y los espacios separan palabras. Los demás signos se ignoran.</p>
        <form method="post" action="1_acronimo.php">
            <label for="frase">Frase</label>
            <input type="text" id="frase" name="frase" value="<?= e($frase) ?>" placeholder="Portable Network Graphics" required>
            <button type="submit">Convertir</button>
        </form>
        <ul class="ejemplos">
            <li><span>As Soon As Possible</span><b>ASAP</b></li>
            <li><span>Liquid-crystal display</span><b>LCD</b></li>
            <li><span>Thank George It's Friday!</span><b>TGIF</b></li>
        </ul>
    </section>
    <section class="panel panel-salida">
        <h3 class="panel-titulo">Resultado</h3>
        <?php if ($error !== ''): ?>
            <p class="error"><?= e($error) ?></p>
        <?php elseif ($siglas !== null): ?>
            <p class="etiqueta">Acrónimo de «<?= e($frase) ?>»</p>
            <p class="grande"><?= e($siglas) ?></p>
        <?php else: ?>
            <p class="espera">Aquí aparecerá el acrónimo.</p>
        <?php endif; ?>
    </section>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
