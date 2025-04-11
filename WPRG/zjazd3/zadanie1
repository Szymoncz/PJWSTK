<?php
require 'calculator_functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];

    switch ($operation) {
        case 'add':
            $result = add($num1, $num2);
            break;
        case 'subtract':
            $result = subtract($num1, $num2);
            break;
        case 'multiply':
            $result = multiply($num1, $num2);
            break;
        case 'divide':
            $result = divide($num1, $num2);
            break;
        default:
            $result = 'Nieprawidłowa operacja';
            break;
    }
    echo "<p>Wynik: $result</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prosty Kalkulator</title>
</head>
<body>
    <h2>Kalkulator</h2>
    <form method="post">
        <input type="number" name="num1" required>
        <select name="operation">
            <option value="add">+</option>
            <option value="subtract">-</option>
            <option value="multiply">*</option>
            <option value="divide">/</option>
        </select>
        <input type="number" name="num2" required>
        <button type="submit">Oblicz</button>
    </form>
</body>
</html>
