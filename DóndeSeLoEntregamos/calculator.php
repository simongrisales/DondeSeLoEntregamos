<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Casillero</title>
    <style>
        body {
            background-color: #100028;
            color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .calculator {
            background-color: #ddd; /* Un color más claro */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            width: 300px;
        }

        h1 {
            text-align: center;
            color: /*#ffcc00*/#100028; /* Color dorado */
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: /*#ffcc00*/#100028; /* Color dorado para las etiquetas */
        }

        input[type="number"], input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #100028;
            border-radius: 5px;
            font-size: 16px;
            background-color: #fff; /* Fondo blanco para los inputs */
            color: #100028; /* Color de texto oscuro */
        }

        input[type="submit"] {
            background-color: /*#ffcc00*/#100028; /* Botón amarillo */
            color: #fff; /* Texto en color oscuro */
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: /*#e6b800*/#100028; /* Amarillo más oscuro al pasar el ratón */
        }

        .result {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: /*#ffcc00*/#100028; /* Color dorado para el resultado */
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>Calculadora</h1>
        <form action="" method="post">
            <label for="peso">Peso en libras:</label>
            <input type="number" id="peso" name="peso" step="0" min="0" required>
            
            <label for="valor_declarado">Valor declarado:</label>
            <input type="number" id="valor_declarado" name="valor_declarado" step="0" min="0" required>
            
            <input type="submit" value="Calcular">
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
                }
                if ($valor_declarado >= 200) {
                    $total += 65;
                }
                echo "<div class='result'>Valor del envío: USD $ " . number_format($total, 2) . "</div>";
            }
        ?>
    </div>
</body>
</html>
