<?php
session_start();

require_once __DIR__ . '/../includes/funciones.php';
require_once __DIR__ . '/../clases.php';

$base = '../';
$titulo = 'Calculadora';
$calculadora = new Calculadora();
$historial = new Historial();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'borrar') {
        $historial->borrar();
    } elseif ($accion === 'calcular') {
        $a = str_replace(',', '.', trim($_POST['a'] ?? ''));
        $b = str_replace(',', '.', trim($_POST['b'] ?? ''));
        $operacion = $_POST['operacion'] ?? '';

        if (!is_numeric($a) || !is_numeric($b)) {
            $_SESSION['error_calculadora'] = 'Ingresa dos números válidos.';
        } else {
            try {
                $resultado = $calculadora->operar((float) $a, (float) $b, $operacion);
                $historial->agregar(
                    formatearNumero($a) . ' ' . $calculadora->simbolo($operacion) . ' ' .
                    formatearNumero($b) . ' = ' . formatearNumero($resultado)
                );
            } catch (InvalidArgumentException $ex) {
                $_SESSION['error_calculadora'] = $ex->getMessage();
            }
        }
    }

    header('Location: 7_calculadora.php');
    exit;
}

$error = isset($_SESSION['error_calculadora']) ? $_SESSION['error_calculadora'] : '';
unset($_SESSION['error_calculadora']);
$lineas = $historial->obtener();

require_once __DIR__ . '/../includes/header.php';
?>
<div class="mesa">
    <section class="panel">
        <h3 class="panel-titulo">Operación</h3>
        <p class="ayuda">Porcentaje calcula «A % de B». Por ejemplo, 20 % de 150 es 30.</p>
        <form method="post" action="7_calculadora.php">
            <input type="hidden" name="accion" value="calcular">
            <div class="fila">
                <div>
                    <label for="a">Primer número</label>
                    <input type="number" step="any" id="a" name="a" required>
                </div>
                <div>
                    <label for="operacion">Operación</label>
                    <select id="operacion" name="operacion">
                        <?php foreach (Calculadora::NOMBRES as $clave => $nombre): ?>
                            <option value="<?= e($clave) ?>"><?= e($nombre) ?> (<?= e(Calculadora::SIMBOLOS[$clave]) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="b">Segundo número</label>
                    <input type="number" step="any" id="b" name="b" required>
                </div>
            </div>
            <button type="submit">Calcular</button>
        </form>
        <?php if ($error !== ''): ?>
            <p class="error"><?= e($error) ?></p>
        <?php endif; ?>
    </section>
    <section class="panel panel-salida">
        <h3 class="panel-titulo">Historial</h3>
        <?php if (count($lineas) === 0): ?>
            <p class="espera">Todavía no hay operaciones.</p>
        <?php else: ?>
            <ol class="historial">
                <?php foreach ($lineas as $linea): ?>
                    <li><?= e($linea) ?></li>
                <?php endforeach; ?>
            </ol>
            <form method="post" action="7_calculadora.php">
                <input type="hidden" name="accion" value="borrar">
                <button type="submit" class="peligro">Borrar historial</button>
            </form>
        <?php endif; ?>
    </section>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
