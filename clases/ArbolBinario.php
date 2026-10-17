<?php
/**
 * Nodo de un árbol binario.
 */
class Nodo
{
    public ?Nodo $izquierdo = null;
    public ?Nodo $derecho = null;

    public function __construct(public string $valor)
    {
    }
}

/**
 * Construye un árbol binario a partir de dos recorridos
 * (preorden-inorden, inorden-postorden o preorden-postorden).
 */
class ArbolBinario
{
    private ?Nodo $raiz = null;
    private bool $ambiguo = false;   // true si preorden-postorden no define un único árbol

    public function raiz(): ?Nodo
    {
        return $this->raiz;
    }

    public function esAmbiguo(): bool
    {
        return $this->ambiguo;
    }

    /* ---------- Construcción ---------- */

    public function desdePreorden_Inorden(array $pre, array $in): void
    {
        $this->validar($pre, $in);
        $this->raiz = $this->construirPreIn($pre, $in);
        $this->verificar(['pre' => $pre, 'in' => $in]);
    }

    public function desdeInorden_Postorden(array $in, array $post): void
    {
        $this->validar($in, $post);
        $this->raiz = $this->construirInPost($in, $post);
        $this->verificar(['in' => $in, 'post' => $post]);
    }

    public function desdePreorden_Postorden(array $pre, array $post): void
    {
        $this->validar($pre, $post);
        $this->ambiguo = false;
        $this->raiz = $this->construirPrePost($pre, $post);
        $this->verificar(['pre' => $pre, 'post' => $post]);
    }

    private function construirPreIn(array $pre, array $in): ?Nodo
    {
        if (count($pre) === 0) {
            return null;
        }
        $nodo = new Nodo($pre[0]);
        $i = array_search($pre[0], $in, true);
        if ($i === false) {
            throw new InvalidArgumentException('Los recorridos no son consistentes.');
        }
        $nodo->izquierdo = $this->construirPreIn(array_slice($pre, 1, $i), array_slice($in, 0, $i));
        $nodo->derecho   = $this->construirPreIn(array_slice($pre, $i + 1), array_slice($in, $i + 1));
        return $nodo;
    }

    private function construirInPost(array $in, array $post): ?Nodo
    {
        if (count($post) === 0) {
            return null;
        }
        $raiz = $post[count($post) - 1];
        $nodo = new Nodo($raiz);
        $i = array_search($raiz, $in, true);
        if ($i === false) {
            throw new InvalidArgumentException('Los recorridos no son consistentes.');
        }
        $nodo->izquierdo = $this->construirInPost(array_slice($in, 0, $i), array_slice($post, 0, $i));
        $nodo->derecho   = $this->construirInPost(array_slice($in, $i + 1), array_slice($post, $i, count($in) - $i - 1));
        return $nodo;
    }

    private function construirPrePost(array $pre, array $post): ?Nodo
    {
        $n = count($pre);
        if ($n === 0) {
            return null;
        }
        $nodo = new Nodo($pre[0]);
        if ($n === 1) {
            return $nodo;
        }

        // La raíz del subárbol izquierdo es el segundo elemento del preorden
        $i = array_search($pre[1], $post, true);
        if ($i === false) {
            throw new InvalidArgumentException('Los recorridos no son consistentes.');
        }
        $tamIzq = $i + 1;

        if ($tamIzq === $n - 1) {
            // Un solo hijo: con preorden-postorden no se sabe si es izquierdo o derecho
            $this->ambiguo = true;
        }

        $nodo->izquierdo = $this->construirPrePost(array_slice($pre, 1, $tamIzq), array_slice($post, 0, $tamIzq));
        $nodo->derecho   = $this->construirPrePost(array_slice($pre, 1 + $tamIzq), array_slice($post, $tamIzq, $n - 1 - $tamIzq));
        return $nodo;
    }

    /* ---------- Validación ---------- */

    private function validar(array $a, array $b): void
    {
        if (count($a) === 0 || count($b) === 0) {
            throw new InvalidArgumentException('Los recorridos no pueden estar vacíos.');
        }
        if (count($a) !== count($b)) {
            throw new InvalidArgumentException('Los recorridos deben tener la misma cantidad de nodos.');
        }
        if (count(array_unique($a)) !== count($a) || count(array_unique($b)) !== count($b)) {
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

    // Comprueba que el árbol construido genera de nuevo los recorridos ingresados
    private function verificar(array $esperados): void
    {
        $mapa = ['pre' => $this->preorden(), 'in' => $this->inorden(), 'post' => $this->postorden()];
        foreach ($esperados as $clave => $recorrido) {
            if ($mapa[$clave] !== $recorrido) {
                throw new InvalidArgumentException('Los recorridos ingresados no corresponden a un mismo árbol.');
            }
        }
    }

    /* ---------- Recorridos ---------- */

    public function preorden(): array
    {
        $r = [];
        $this->recorrerPre($this->raiz, $r);
        return $r;
    }

    public function inorden(): array
    {
        $r = [];
        $this->recorrerIn($this->raiz, $r);
        return $r;
    }

    public function postorden(): array
    {
        $r = [];
        $this->recorrerPost($this->raiz, $r);
        return $r;
    }

    private function recorrerPre(?Nodo $n, array &$r): void
    {
        if ($n === null) {
            return;
        }
        $r[] = $n->valor;
        $this->recorrerPre($n->izquierdo, $r);
        $this->recorrerPre($n->derecho, $r);
    }

    private function recorrerIn(?Nodo $n, array &$r): void
    {
        if ($n === null) {
            return;
        }
        $this->recorrerIn($n->izquierdo, $r);
        $r[] = $n->valor;
        $this->recorrerIn($n->derecho, $r);
    }

    private function recorrerPost(?Nodo $n, array &$r): void
    {
        if ($n === null) {
            return;
        }
        $this->recorrerPost($n->izquierdo, $r);
        $this->recorrerPost($n->derecho, $r);
        $r[] = $n->valor;
    }

    /* ---------- Dibujo (HTML + CSS, sin JavaScript) ---------- */

    public function aHtml(): string
    {
        return '<div class="arbol"><ul>' . $this->nodoAHtml($this->raiz) . '</ul></div>';
    }

    private function nodoAHtml(?Nodo $n): string
    {
        if ($n === null) {
            return '';
        }
        $html = '<li><span>' . htmlspecialchars($n->valor, ENT_QUOTES, 'UTF-8') . '</span>';

        if ($n->izquierdo !== null || $n->derecho !== null) {
            $vacio = '<li class="vacio"><span>.</span></li>';
            $html .= '<ul>';
            $html .= $n->izquierdo !== null ? $this->nodoAHtml($n->izquierdo) : $vacio;
            $html .= $n->derecho !== null ? $this->nodoAHtml($n->derecho) : $vacio;
            $html .= '</ul>';
        }
        return $html . '</li>';
    }
}
