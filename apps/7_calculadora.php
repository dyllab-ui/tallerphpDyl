<?php
session_start();   // Debe ir antes de imprimir cualquier HTML

require_once __DIR__ . '/../includes/funciones.php';
require_once __DIR__ . '/../clases/Calculadora.php';
require_once __DIR__ . '/../clases/Historial.php';

$base      = '../';
$titulo    = 'Calculadora';
$calc      = new Calculadora();
$historial = new Historial();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'borrar') {
        $historial->borrar();
    } elseif ($accion === 'calcular') {
        $a  = str_replace(',', '.', trim($_POST['a'] ?? ''));
        $b  = str_replace(',', '.', trim($_POST['b'] ?? ''));
        $op = $_POST['operacion'] ?? '';

        if (!is_numeric($a) || !is_numeric($b)) {
            $_SESSION['error_calculadora'] = 'Ingrese dos números válidos.';
        } else {
            try {
                $resultado = $calc->operar((float) $a, (float) $b, $op);
                $historial->agregar(
                    formatearNumero((float) $a) . ' ' . $calc->simbolo($op) . ' ' .
                    formatearNumero((float) $b) . ' = ' . formatearNumero($resultado)
                );
            } catch (DivisionByZeroError | InvalidArgumentException $ex) {
                $_SESSION['error_calculadora'] = $ex->getMessage();
            }
        }
    }

    // Patrón Post/Redirect/Get: evita que al recargar se repita la operación
    header('Location: 7_calculadora.php');
    exit;
}

$error = $_SESSION['error_calculadora'] ?? '';
unset($_SESSION['error_calculadora']);

require_once __DIR__ . '/../includes/header.php';
?>
<div class="tarjeta">
    <h2>7. Calculadora</h2>
    <p><small>Porcentaje: calcula "A % de B" (por ejemplo, 20 % de 150 = 30).</small></p>

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
                    <?php foreach (Calculadora::OPERACIONES as $clave => $simbolo): ?>
                        <option value="<?= $clave ?>"><?= e(ucfirst($clave)) ?> (<?= e($simbolo) ?>)</option>
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
</div>

<div class="tarjeta">
    <h2>Historial</h2>
    <?php if (count($historial->obtener()) === 0): ?>
        <p>Todavía no hay operaciones.</p>
    <?php else: ?>
        <ol class="historial">
            <?php foreach ($historial->obtener() as $linea): ?>
                <li><?= e($linea) ?></li>
            <?php endforeach; ?>
        </ol>
        <form method="post" action="7_calculadora.php">
            <input type="hidden" name="accion" value="borrar">
            <button type="submit" class="peligro">Borrar historial</button>
        </form>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
