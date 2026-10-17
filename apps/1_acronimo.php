<?php
require_once __DIR__ . '/../clases/Acronimo.php';

$base   = '../';
$titulo = 'acronimo';
$frase  = '';
$siglas = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = trim($_POST['frase'] ?? '');
    if ($frase !== '') {
        $siglas = (new acronimo($frase))->generar();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="tarjeta">
    <h2>1. Convertir una frase en su acrónimo</h2>
    <p>Los guiones y espacios separan palabras; los demás signos de puntuación se eliminan.</p>
    <p>Ejemplos: <em>As Soon As Possible</em> → ASAP, <em>Liquid-crystal display</em> → LCD, <em>Thank George It's Friday!</em> → TGIF.</p>

    <form method="post" action="1_acronimo.php">
        <label for="frase">Frase</label>
        <input type="text" id="frase" name="frase" value="<?= ($frase) ?>" required>
        <button type="submit">Convertir</button>
    </form>

    <?php if ($siglas !== null): ?>
        <div class="resultado">
            <p>Acrónimo:</p>
            <p class="grande"><?= e($siglas) ?></p>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
