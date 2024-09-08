<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de casillero</title>
</head>
<body>
    <h1>Calculadora</h1>
    <form action="calculator.php" method="post">
        <label for="peso">Peso en libras:</label>
        <input type="number" id="peso" name="peso" step="0" min="0" required>
        <br><br>
        <label for="valor declarado">Valor declarado:</label>
        <input type="number" id="valor_declarado" name="valor_declarado" step="0" min="0" required>
        <br><br>
        <input type="submit" value="calcular">
    </form>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valor_libra_fijo = 4;
        $peso = $_POST['peso'];
        $valor_declarado = $_POST['valor_declarado'];
        if ($peso <= 10) {
            $total = 20;
        } else {
            $libras_extra = $peso - 10;
            $total = $libras_extra * $valor_libra_fijo + 20;
        };
        if ($valor_declarado >= 200) {
            $total = $total + 65;
        };
        echo "<h2>Valor del envio: $" . number_format($total) . "</h2>";
    };
?>
</body>
</html>