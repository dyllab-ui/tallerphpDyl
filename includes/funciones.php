<?php
/**
 * Funciones de ayuda compartidas por todas las aplicaciones.
 */

// Escapa texto para mostrarlo de forma segura en HTML.
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// Quita ceros innecesarios: 5.0000000000 -> 5 ; 2.5000 -> 2.5
function formatearNumero(float $numero): string
{
    $texto = number_format($numero, 10, '.', '');
    $texto = rtrim(rtrim($texto, '0'), '.');
    return ($texto === '' || $texto === '-0') ? '0' : $texto;
}

// Convierte "A, B  C" o "A -> B -> C" en un arreglo ['A','B','C'].
function parsearLista(string $texto): array
{
    $texto = trim($texto);
    if ($texto === '') {
        return [];
    }
    $partes = preg_split('/[\s,;>→\-]+/u', $texto, -1, PREG_SPLIT_NO_EMPTY);
    return array_values($partes);
}

// Lista de aplicaciones del taller (archivo => título del menú).
function menuAplicaciones(): array
{
    return [
        '1_acronimo.php'    => '1. Acrónimo',
        '2_secuencias.php'  => '2. Fibonacci / Factorial',
        '3_estadistica.php' => '3. Promedio, mediana y moda',
        '4_conjuntos.php'   => '4. Conjuntos',
        '5_binario.php'     => '5. Decimal a binario',
        '6_arbol.php'       => '6. Árbol binario',
        '7_calculadora.php' => '7. Calculadora',
    ];
}
