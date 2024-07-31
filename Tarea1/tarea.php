<?php
// Declaración de variables
$integer = 10;          
$float = 20.5;           
$string = "Hola Mundo";  
$boolean = true;         
$array = array(1, 2, 3, 4, 5); 

// Muestra el contenido de las variables
echo "Integer: $integer<br>";
echo "Float: $float<br>";
echo "String: $string<br>";
echo "Boolean: " . ($boolean ? "true" : "false") . "<br>";
echo "Array: " . implode(", ", $array) . "<br>";
?>


<?php
// Operaciones aritméticas
$sum = $integer + $float;
$product = $integer * $float;

// Muestra los resultados
echo "Suma: $sum<br>";
echo "Producto: $product<br>";
?>


<?php
// Concatenación de cadenas
$string1 = "Hola";
$string2 = "Mundo";
$concatenated = $string1 . " " . $string2;

// Obtención de la longitud de la cadena
$length = strlen($concatenated);

// Muestra los resultados
echo "Cadena concatenada: $concatenated<br>";
echo "Longitud de la cadena: $length<br>";
?>


<?php
// Estructura condicional
if ($boolean) {
    echo "La variable booleana es true.<br>";
} else {
    echo "La variable booleana es false.<br>";
}
?>


<?php
// Definición del array
$numbers = array(10, 20, 30, 40, 50);

// Muestra un elemento específico del array
echo "Elemento en índice 2: " . $numbers[2] . "<br>";
?>


