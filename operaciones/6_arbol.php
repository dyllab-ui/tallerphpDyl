<?php
require_once __DIR__ . '/../clases.php';
require_once __DIR__ . '/../includes/funciones.php';

$base = '../';
$titulo = 'Árbol binario';
$texto = array('pre' => '', 'in' => '', 'post' => '');
$error = '';
$arbol = null;
$usados = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($texto as $clave => $valor) {
        $texto[$clave] = trim($_POST[$clave] ?? '');
    }

    $pre = parsearLista($texto['pre']);
    $in = parsearLista($texto['in']);
    $post = parsearLista($texto['post']);

    $ingresados = (count($pre) > 0 ? 1 : 0) + (count($in) > 0 ? 1 : 0) + (count($post) > 0 ? 1 : 0);

    if ($ingresados < 2) {
        $error = 'Debes ingresar mínimo dos recorridos.';
    } else {
        try {
            $arbol = new ArbolBinario();

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
<div class="mesa apilada">
    <section class="panel">
        <h3 class="panel-titulo">Recorridos de entrada</h3>
        <p class="ayuda">Ingresa mínimo dos recorridos con los nodos separados por comas, espacios o flechas. Si ingresas los tres, se usa preorden - inorden.</p>
        <form method="post" action="6_arbol.php">
            <div class="fila">
                <div>
                    <label for="pre">Preorden</label>
                    <input type="text" id="pre" name="pre" value="<?= e($texto['pre']) ?>" placeholder="A, B, D, E, C">
                </div>
                <div>
                    <label for="in">Inorden</label>
                    <input type="text" id="in" name="in" value="<?= e($texto['in']) ?>" placeholder="D, B, E, A, C">
                </div>
                <div>
                    <label for="post">Postorden</label>
                    <input type="text" id="post" name="post" value="<?= e($texto['post']) ?>" placeholder="D, E, B, C, A">
                </div>
            </div>
            <button type="submit">Construir árbol</button>
        </form>
    </section>
    <section class="panel panel-salida">
        <h3 class="panel-titulo">Árbol construido</h3>
        <?php if ($error !== ''): ?>
            <p class="error"><?= e($error) ?></p>
        <?php elseif ($arbol !== null): ?>
            <p class="etiqueta">Construido con <?= e($usados) ?></p>
            <?= $arbol->aSvg() ?>
            <div class="cifras una">
                <div class="cifra"><span>Preorden</span><strong><?= e(implode(' → ', $arbol->preorden())) ?></strong></div>
                <div class="cifra"><span>Inorden</span><strong><?= e(implode(' → ', $arbol->inorden())) ?></strong></div>
                <div class="cifra"><span>Postorden</span><strong><?= e(implode(' → ', $arbol->postorden())) ?></strong></div>
            </div>
            <?php if ($arbol->esAmbiguo()): ?>
                <p class="aviso">Con preorden - postorden no siempre existe un único árbol: si un nodo tiene un solo hijo no se sabe de qué lado va. Aquí se dibujó a la izquierda.</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="espera">Aquí aparecerá el árbol.</p>
        <?php endif; ?>
    </section>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
