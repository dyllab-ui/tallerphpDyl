<?php
require_once __DIR__ . '/../clases/ArbolBinario.php';
require_once __DIR__ . '/../includes/funciones.php';

$base   = '../';
$titulo = 'Árbol binario';
$texto  = ['pre' => '', 'in' => '', 'post' => ''];
$error  = '';
$arbol  = null;
$usados = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($texto as $clave => $_) {
        $texto[$clave] = trim($_POST[$clave] ?? '');
    }
    $pre  = parsearLista($texto['pre']);
    $in   = parsearLista($texto['in']);
    $post = parsearLista($texto['post']);

    $ingresados = (count($pre) > 0) + (count($in) > 0) + (count($post) > 0);

    if ($ingresados < 2) {
        $error = 'Debe ingresar mínimo dos recorridos.';
    } else {
        try {
            $arbol = new ArbolBinario();
            // Si ingresa los tres, o preorden-inorden, se usa preorden-inorden
            if (count($pre) > 0 && count($in) > 0) {
                $arbol->desdePreorden_Inorden($pre, $in);
                $usados = 'preorden - inorden';
            } elseif (count($in) > 0 && count($post) > 0) {
                $arbol->desdeInorden_Postorden($in, $post);
                $usados = 'inorden - postorden';
            } else {
                $arbol->desdePreorden_Postorden($pre, $post);
                $usados = 'preorden - postorden';
            }
        } catch (InvalidArgumentException $ex) {
            $error = $ex->getMessage();
            $arbol = null;
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<div class="tarjeta">
    <h2>6. Construir un árbol binario desde sus recorridos</h2>
    <p>Ingrese mínimo dos recorridos (nodos separados por comas, espacios o flechas). Si ingresa los tres, se usa preorden - inorden.</p>
    <p><small>Ejemplo: Preorden <code>A, B, D, E, C</code> &nbsp; Inorden <code>D, B, E, A, C</code> &nbsp; Postorden <code>D, E, B, C, A</code></small></p>

    <form method="post" action="6_arbol.php">
        <label for="pre">Preorden</label>
        <input type="text" id="pre" name="pre" value="<?= e($texto['pre']) ?>">

        <label for="in">Inorden</label>
        <input type="text" id="in" name="in" value="<?= e($texto['in']) ?>">

        <label for="post">Postorden</label>
        <input type="text" id="post" name="post" value="<?= e($texto['post']) ?>">

        <button type="submit">Construir árbol</button>
    </form>

    <?php if ($error !== ''): ?>
        <p class="error"><?= e($error) ?></p>
    <?php elseif ($arbol !== null): ?>
        <div class="resultado">
            <p>Árbol construido con: <strong><?= e($usados) ?></strong></p>
            <?= $arbol->aHtml() ?>
            <p><strong>Preorden:</strong> <?= e(implode(' → ', $arbol->preorden())) ?></p>
            <p><strong>Inorden:</strong> <?= e(implode(' → ', $arbol->inorden())) ?></p>
            <p><strong>Postorden:</strong> <?= e(implode(' → ', $arbol->postorden())) ?></p>
        </div>
        <?php if ($arbol->esAmbiguo()): ?>
            <p class="aviso">Con preorden - postorden no siempre hay un único árbol: cuando un nodo tiene un solo hijo no se sabe si es izquierdo o derecho. Se dibujó como hijo izquierdo.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
