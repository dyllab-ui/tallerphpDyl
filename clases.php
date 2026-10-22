<?php

class Acronimo
{
    private $frase;

    public function __construct($frase)
    {
        $this->frase = $frase;
    }

    public function generar()
    {
        $limpia = preg_replace('/[^\p{L}\p{N}\s\-]/u', '', $this->frase);
        if ($limpia === null) {
            throw new InvalidArgumentException('El texto contiene caracteres no válidos.');
        }

        $palabras = preg_split('/[\s\-]+/u', trim($limpia), -1, PREG_SPLIT_NO_EMPTY);
        $resultado = '';

        foreach ($palabras as $palabra) {
            if (preg_match('/^./us', $palabra, $letra)) {
                $resultado .= $this->mayuscula($letra[0]);
            }
        }

        return $resultado;
    }

    private function mayuscula($letra)
    {
        if (function_exists('mb_strtoupper')) {
            return mb_strtoupper($letra, 'UTF-8');
        }
        return strtoupper($letra);
    }
}


class Fibonacci
{
    const MINIMO = 1;
    const MAXIMO = 90;
    private $cantidad;

    public function __construct($cantidad)
    {
        if ($cantidad < self::MINIMO || $cantidad > self::MAXIMO) {
            throw new InvalidArgumentException('Ingresa un número entre ' . self::MINIMO . ' y ' . self::MAXIMO . '.');
        }
        $this->cantidad = $cantidad;
    }

    public function serie()
    {
        $resultado = array();
        $a = 0;
        $b = 1;

        for ($i = 0; $i < $this->cantidad; $i++) {
            $resultado[] = $a;
            $siguiente = $a + $b;
            $a = $b;
            $b = $siguiente;
        }

        return $resultado;
    }

    public function titulo()
    {
        return 'Primeros ' . $this->cantidad . ' términos de la sucesión';
    }
}


class Factorial
{
    const MINIMO = 0;
    const MAXIMO = 20;
    private $numero;

    public function __construct($numero)
    {
        if ($numero < self::MINIMO || $numero > self::MAXIMO) {
            throw new InvalidArgumentException('Ingresa un número entre ' . self::MINIMO . ' y ' . self::MAXIMO . '.');
        }
        $this->numero = $numero;
    }

    public function serie()
    {
        $resultado = array();
        $factorial = 1;

        for ($i = 0; $i <= $this->numero; $i++) {
            if ($i > 0) {
                $factorial = $factorial * $i;
            }
            $resultado[$i] = $factorial;
        }

        return $resultado;
    }

    public function resultado()
    {
        $serie = $this->serie();
        return end($serie);
    }

    public function titulo()
    {
        return 'Factorial de ' . $this->numero;
    }
}


class Estadistica
{
    private $datos;

    public function __construct($datos)
    {
        if (count($datos) == 0) {
            throw new InvalidArgumentException('Debes ingresar al menos un número.');
        }

        $this->datos = array();
        foreach ($datos as $dato) {
            $this->datos[] = (float) $dato;
        }
    }

    public function cantidad()
    {
        return count($this->datos);
    }

    public function promedio()
    {
        $suma = 0;
        foreach ($this->datos as $numero) {
            $suma = $suma + $numero;
        }
        return $suma / count($this->datos);
    }

    public function mediana()
    {
        $ordenados = $this->datos;
        sort($ordenados);
        $cantidad = count($ordenados);
        $mitad = intdiv($cantidad, 2);

        if ($cantidad % 2 == 1) {
            return $ordenados[$mitad];
        }
        return ($ordenados[$mitad - 1] + $ordenados[$mitad]) / 2;
    }

    public function moda()
    {
        $frecuencias = array();
        foreach ($this->datos as $numero) {
            $clave = (string) $numero;
            if (isset($frecuencias[$clave])) {
                $frecuencias[$clave]++;
            } else {
                $frecuencias[$clave] = 1;
            }
        }

        $mayor = 1;
        foreach ($frecuencias as $veces) {
            if ($veces > $mayor) {
                $mayor = $veces;
            }
        }

        $modas = array();
        if ($mayor == 1) {
            return $modas;
        }

        foreach ($frecuencias as $numero => $veces) {
            if ($veces == $mayor) {
                $modas[] = (float) $numero;
            }
        }
        sort($modas);
        return $modas;
    }
}


class Conjunto
{
    private $elementos;

    public function __construct($elementos)
    {
        $this->elementos = array();

        foreach ($elementos as $numero) {
            $numero = (int) $numero;
            if (!in_array($numero, $this->elementos)) {
                $this->elementos[] = $numero;
            }
        }
        sort($this->elementos);
    }

    public function elementos()
    {
        return $this->elementos;
    }

    public function union($otro)
    {
        $todos = $this->elementos;
        foreach ($otro->elementos() as $numero) {
            if (!in_array($numero, $todos)) {
                $todos[] = $numero;
            }
        }
        return new Conjunto($todos);
    }

    public function interseccion($otro)
    {
        $comunes = array();
        foreach ($this->elementos as $numero) {
            if (in_array($numero, $otro->elementos())) {
                $comunes[] = $numero;
            }
        }
        return new Conjunto($comunes);
    }

    public function diferencia($otro)
    {
        $diferentes = array();
        foreach ($this->elementos as $numero) {
            if (!in_array($numero, $otro->elementos())) {
                $diferentes[] = $numero;
            }
        }
        return new Conjunto($diferentes);
    }

    public function __toString()
    {
        if (count($this->elementos) == 0) {
            return 'Conjunto vacío';
        }
        return '{ ' . implode(', ', $this->elementos) . ' }';
    }
}


class ConversorBinario
{
    private $numero;
    private $pasos = array();

    public function __construct($numero)
    {
        $this->numero = $numero;
    }

    public function convertir()
    {
        $this->pasos = array();

        if ($this->numero == 0) {
            return '0';
        }

        $valor = abs($this->numero);
        $binario = '';

        while ($valor > 0) {
            $cociente = intdiv($valor, 2);
            $residuo = $valor % 2;
            $this->pasos[] = array(
                'dividendo' => $valor,
                'cociente' => $cociente,
                'residuo' => $residuo
            );
            $binario = $residuo . $binario;
            $valor = $cociente;
        }

        if ($this->numero < 0) {
            $binario = '-' . $binario;
        }
        return $binario;
    }

    public function pasos()
    {
        return $this->pasos;
    }
}


class Calculadora
{
    const NOMBRES = array(
        'suma' => 'Suma',
        'resta' => 'Resta',
        'multiplicacion' => 'Multiplicación',
        'division' => 'División',
        'porcentaje' => 'Porcentaje'
    );

    const SIMBOLOS = array(
        'suma' => '+',
        'resta' => '-',
        'multiplicacion' => '×',
        'division' => '÷',
        'porcentaje' => '% de'
    );

    public function operar($a, $b, $operacion)
    {
        if ($operacion == 'suma') {
            return $a + $b;
        } elseif ($operacion == 'resta') {
            return $a - $b;
        } elseif ($operacion == 'multiplicacion') {
            return $a * $b;
        } elseif ($operacion == 'division') {
            if ($b == 0) {
                throw new InvalidArgumentException('No se puede dividir entre cero.');
            }
            return $a / $b;
        } elseif ($operacion == 'porcentaje') {
            return ($a * $b) / 100;
        }

        throw new InvalidArgumentException('Operación no válida.');
    }

    public function simbolo($operacion)
    {
        if (isset(self::SIMBOLOS[$operacion])) {
            return self::SIMBOLOS[$operacion];
        }
        return '?';
    }
}


class Historial
{
    public function __construct()
    {
        if (!isset($_SESSION['historial_calculadora'])) {
            $_SESSION['historial_calculadora'] = array();
        }
    }

    public function agregar($operacion)
    {
        array_unshift($_SESSION['historial_calculadora'], $operacion);
    }

    public function obtener()
    {
        return $_SESSION['historial_calculadora'];
    }

    public function borrar()
    {
        $_SESSION['historial_calculadora'] = array();
    }
}


class Nodo
{
    public $valor;
    public $izquierdo = null;
    public $derecho = null;

    public function __construct($valor)
    {
        $this->valor = $valor;
    }
}


class ArbolBinario
{
    private $raiz = null;
    private $ambiguo = false;
    private $sepX = 66;
    private $sepY = 86;
    private $margen = 44;
    private $radio = 24;

    public function esAmbiguo()
    {
        return $this->ambiguo;
    }

    public function desdePreorden_Inorden($pre, $in)
    {
        $this->validar($pre, $in);
        $this->raiz = $this->construirPreIn($pre, $in);
        $this->verificar(array('pre' => $pre, 'in' => $in));
    }

    public function desdeInorden_Postorden($in, $post)
    {
        $this->validar($in, $post);
        $this->raiz = $this->construirInPost($in, $post);
        $this->verificar(array('in' => $in, 'post' => $post));
    }

    public function desdePreorden_Postorden($pre, $post)
    {
        $this->validar($pre, $post);
        $this->ambiguo = false;
        $this->raiz = $this->construirPrePost($pre, $post);
        $this->verificar(array('pre' => $pre, 'post' => $post));
    }

    private function construirPreIn($pre, $in)
    {
        if (count($pre) == 0) {
            return null;
        }

        $nodo = new Nodo($pre[0]);
        $i = array_search($pre[0], $in, true);
        if ($i === false) {
            throw new InvalidArgumentException('Los recorridos no son consistentes.');
        }

        $nodo->izquierdo = $this->construirPreIn(array_slice($pre, 1, $i), array_slice($in, 0, $i));
        $nodo->derecho = $this->construirPreIn(array_slice($pre, $i + 1), array_slice($in, $i + 1));
        return $nodo;
    }

    private function construirInPost($in, $post)
    {
        if (count($post) == 0) {
            return null;
        }

        $raiz = $post[count($post) - 1];
        $nodo = new Nodo($raiz);
        $i = array_search($raiz, $in, true);
        if ($i === false) {
            throw new InvalidArgumentException('Los recorridos no son consistentes.');
        }

        $nodo->izquierdo = $this->construirInPost(array_slice($in, 0, $i), array_slice($post, 0, $i));
        $nodo->derecho = $this->construirInPost(array_slice($in, $i + 1), array_slice($post, $i, count($in) - $i - 1));
        return $nodo;
    }

    private function construirPrePost($pre, $post)
    {
        $n = count($pre);
        if ($n == 0) {
            return null;
        }

        $nodo = new Nodo($pre[0]);
        if ($n == 1) {
            return $nodo;
        }

        $i = array_search($pre[1], $post, true);
        if ($i === false) {
            throw new InvalidArgumentException('Los recorridos no son consistentes.');
        }
        $tamIzq = $i + 1;

        if ($tamIzq == $n - 1) {
            $this->ambiguo = true;
        }

        $nodo->izquierdo = $this->construirPrePost(array_slice($pre, 1, $tamIzq), array_slice($post, 0, $tamIzq));
        $nodo->derecho = $this->construirPrePost(array_slice($pre, 1 + $tamIzq), array_slice($post, $tamIzq, $n - 1 - $tamIzq));
        return $nodo;
    }

    private function validar($a, $b)
    {
        if (count($a) == 0 || count($b) == 0) {
            throw new InvalidArgumentException('Los recorridos no pueden estar vacíos.');
        }
        if (count($a) != count($b)) {
            throw new InvalidArgumentException('Los recorridos deben tener la misma cantidad de nodos.');
        }
        if (count(array_unique($a)) != count($a) || count(array_unique($b)) != count($b)) {
            throw new InvalidArgumentException('Los nodos no pueden repetirse dentro de un recorrido.');
        }

        $x = $a;
        $y = $b;
        sort($x);
        sort($y);
        if ($x !== $y) {
            throw new InvalidArgumentException('Los recorridos deben contener los mismos nodos.');
        }
    }

    private function verificar($esperados)
    {
        $mapa = array(
            'pre' => $this->preorden(),
            'in' => $this->inorden(),
            'post' => $this->postorden()
        );

        foreach ($esperados as $clave => $recorrido) {
            if ($mapa[$clave] !== $recorrido) {
                throw new InvalidArgumentException('Los recorridos ingresados no corresponden a un mismo árbol.');
            }
        }
    }

    public function preorden()
    {
        $r = array();
        $this->recorrerPre($this->raiz, $r);
        return $r;
    }

    public function inorden()
    {
        $r = array();
        $this->recorrerIn($this->raiz, $r);
        return $r;
    }

    public function postorden()
    {
        $r = array();
        $this->recorrerPost($this->raiz, $r);
        return $r;
    }

    private function recorrerPre($n, &$r)
    {
        if ($n === null) {
            return;
        }
        $r[] = $n->valor;
        $this->recorrerPre($n->izquierdo, $r);
        $this->recorrerPre($n->derecho, $r);
    }

    private function recorrerIn($n, &$r)
    {
        if ($n === null) {
            return;
        }
        $this->recorrerIn($n->izquierdo, $r);
        $r[] = $n->valor;
        $this->recorrerIn($n->derecho, $r);
    }

    private function recorrerPost($n, &$r)
    {
        if ($n === null) {
            return;
        }
        $this->recorrerPost($n->izquierdo, $r);
        $this->recorrerPost($n->derecho, $r);
        $r[] = $n->valor;
    }

    public function aSvg()
    {
        if ($this->raiz === null) {
            return '';
        }

        $posiciones = array();
        $columna = 0;
        $nivelMaximo = 0;
        $this->calcularPosiciones($this->raiz, 0, $columna, $posiciones, $nivelMaximo);

        $ancho = $this->margen * 2 + max(0, $columna - 1) * $this->sepX;
        $alto = $this->margen * 2 + $nivelMaximo * $this->sepY;

        $lineas = '';
        $nodos = '';
        $this->dibujarNodo($this->raiz, $posiciones, $lineas, $nodos);

        $defs = '<defs><radialGradient id="esfera" cx="32%" cy="26%" r="78%">'
            . '<stop offset="0%" stop-color="#ffffff"/>'
            . '<stop offset="30%" stop-color="#c4fff2"/>'
            . '<stop offset="70%" stop-color="#4fd9d0"/>'
            . '<stop offset="100%" stop-color="#2a86d0"/>'
            . '</radialGradient></defs>';

        return '<div class="arbol-svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $ancho . ' ' . $alto . '"'
            . ' width="' . $ancho . '" height="' . $alto . '" style="max-width:100%;height:auto"'
            . ' role="img" aria-label="Árbol binario">' . $defs . $lineas . $nodos . '</svg></div>';
    }

    private function calcularPosiciones($n, $nivel, &$columna, &$posiciones, &$nivelMaximo)
    {
        if ($n === null) {
            return;
        }

        $this->calcularPosiciones($n->izquierdo, $nivel + 1, $columna, $posiciones, $nivelMaximo);
        $posiciones[spl_object_id($n)] = array($columna, $nivel);
        $columna++;
        $nivelMaximo = max($nivelMaximo, $nivel);
        $this->calcularPosiciones($n->derecho, $nivel + 1, $columna, $posiciones, $nivelMaximo);
    }

    private function coordenadas($n, $posiciones)
    {
        $posicion = $posiciones[spl_object_id($n)];
        return array(
            $this->margen + $posicion[0] * $this->sepX,
            $this->margen + $posicion[1] * $this->sepY
        );
    }

    private function dibujarNodo($n, $posiciones, &$lineas, &$nodos)
    {
        list($x, $y) = $this->coordenadas($n, $posiciones);

        foreach (array($n->izquierdo, $n->derecho) as $hijo) {
            if ($hijo !== null) {
                list($hx, $hy) = $this->coordenadas($hijo, $posiciones);
                $lineas .= '<line x1="' . $x . '" y1="' . $y . '" x2="' . $hx . '" y2="' . $hy
                    . '" stroke="#a6f7ea" stroke-width="3" stroke-linecap="round" opacity=".9"/>';
                $this->dibujarNodo($hijo, $posiciones, $lineas, $nodos);
            }
        }

        $brilloX = round($x - $this->radio * 0.3, 1);
        $brilloY = round($y - $this->radio * 0.46, 1);

        $nodos .= '<circle cx="' . $x . '" cy="' . $y . '" r="' . $this->radio
            . '" fill="url(#esfera)" stroke="#e9ffff" stroke-width="2"/>';
        $nodos .= '<ellipse cx="' . $brilloX . '" cy="' . $brilloY . '" rx="'
            . round($this->radio * 0.5, 1) . '" ry="' . round($this->radio * 0.26, 1) . '" fill="#ffffff" opacity=".6"/>';
        $nodos .= '<text x="' . $x . '" y="' . ($y + 1) . '" text-anchor="middle" dy=".35em"'
            . ' font-family="Segoe UI, Arial, sans-serif" font-size="18" font-weight="bold" fill="#07354a">'
            . htmlspecialchars($n->valor, ENT_QUOTES, 'UTF-8') . '</text>';
    }
}
