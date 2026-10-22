<?php

function e($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

function formatearNumero($numero)
{
    $texto = number_format((float) $numero, 10, '.', '');
    $texto = rtrim(rtrim($texto, '0'), '.');
    if ($texto === '' || $texto === '-0') {
        return '0';
    }
    return $texto;
}

function parsearLista($texto)
{
    $texto = trim($texto);
    if ($texto === '') {
        return array();
    }
    $partes = preg_split('/[\s,;>→\-]+/u', $texto, -1, PREG_SPLIT_NO_EMPTY);
    return array_values($partes);
}

function estaciones()
{
    return array(
        '1_acronimo.php' => array(
            'nombre' => '1. Acrónimo',
            'titulo' => 'Acrónimo de una frase',
            'resumen' => 'Convierte una frase en sus iniciales.',
            'descripcion' => 'Escribe un nombre largo y obtén sus siglas.',
            'icono' => '✦',
            'acento' => '#8fdcff',
            'brillo' => 'rgba(81, 195, 255, .45)'
        ),
        '2_secuencias.php' => array(
            'nombre' => '2. Fibonacci / Factorial',
            'titulo' => 'Fibonacci y factorial',
            'resumen' => 'Explora Fibonacci y el factorial.',
            'descripcion' => 'Genera la serie completa de la operación que elijas.',
            'icono' => '∞',
            'acento' => '#8dffd8',
            'brillo' => 'rgba(69, 255, 197, .4)'
        ),
        '3_estadistica.php' => array(
            'nombre' => '3. Promedio, mediana y moda',
            'titulo' => 'Promedio, mediana y moda',
            'resumen' => 'Calcula promedio, mediana y moda.',
            'descripcion' => 'Tú decides cuántos números ingresar.',
            'icono' => '∑',
            'acento' => '#cdb4ff',
            'brillo' => 'rgba(186, 139, 255, .42)'
        ),
        '4_conjuntos.php' => array(
            'nombre' => '4. Conjuntos',
            'titulo' => 'Operaciones entre conjuntos',
            'resumen' => 'Compara dos conjuntos de números.',
            'descripcion' => 'Unión, intersección y diferencias entre A y B.',
            'icono' => '◉',
            'acento' => '#ffb0d4',
            'brillo' => 'rgba(255, 133, 192, .42)'
        ),
        '5_binario.php' => array(
            'nombre' => '5. Decimal a binario',
            'titulo' => 'Decimal a binario',
            'resumen' => 'Convierte números a sistema binario.',
            'descripcion' => 'Divisiones sucesivas entre 2, paso a paso.',
            'icono' => '01',
            'acento' => '#ffe38a',
            'brillo' => 'rgba(255, 221, 104, .43)'
        ),
        '6_arbol.php' => array(
            'nombre' => '6. Árbol binario',
            'titulo' => 'Árbol binario',
            'resumen' => 'Forma un árbol a partir de recorridos.',
            'descripcion' => 'Reconstruye el árbol con dos de sus recorridos.',
            'icono' => '⌘',
            'acento' => '#ffbb92',
            'brillo' => 'rgba(255, 160, 110, .42)'
        ),
        '7_calculadora.php' => array(
            'nombre' => '7. Calculadora',
            'titulo' => 'Calculadora',
            'resumen' => 'Realiza operaciones y guarda el historial.',
            'descripcion' => 'Operaciones básicas con historial de resultados.',
            'icono' => '＋',
            'acento' => '#c4ff8f',
            'brillo' => 'rgba(170, 255, 110, .4)'
        )
    );
}
