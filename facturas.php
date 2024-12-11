<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo-container img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .logo-container span {
            font-size: 24px;
            font-weight: bold;
        }
        .menu {
            display: flex;
            gap: 15px;
        }
        .menu a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .menu a:hover {
            background-color: #555;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .form-container label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .form-container input[type="text"], .form-container input[type="number"], .form-container input[type="date"], .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .form-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }
        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }
        .form-container input[type="submit"].buscar {
            background-color: #007bff;
        }
        .form-container input[type="submit"].buscar:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <div class="header-container">
        <div class="logo-container">
            <img src="Logo_minimalista_para_una_empresa_de_compraventa.jpg" alt="Logo">
            <span>Compraventa la 14</span>
        </div>
        <div class="menu">
            <a href="cliente.html">Inicio</a>
            <a href="producto.html">Productos</a>
        </div>
    </div>

    <!-- Formulario de Factura -->
    <div class="form-container">
        <?php
        $nombreCliente = $nombreProducto = $cantidad = $valorTotal = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
            $nombre = htmlspecialchars($_POST["nombre"]);

            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "almacen";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Conexión exitosa a la base de datos <br>";

                // Consulta para obtener el nombre específico y los productos asociados
                $sql = "SELECT cliente.nombre, producto.nombre_producto, producto.valor
                        FROM cliente 
                        JOIN producto ON cliente.id_cliente = producto.id_producto
                        WHERE cliente.nombre = :nombre";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();

                // Almacenar el resultado
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $nombreCliente = $row['nombre'];
                    $nombreProducto = $row['nombre_producto'];

                    // Calcular el valor total basado en la cantidad y el valor del producto
                    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;
                    $valorProducto = $row['valor'];
                    $valorTotal = $cantidad * $valorProducto;

                    // Insertar los datos en la tabla facturas
                    if (isset($_POST['enviar'])) {
                        $sqlInsert = "INSERT INTO facturas (nombre, nombre_producto, cantidad, valor_total) VALUES (:nombre, :nombre_producto, :cantidad, :valor_total)";
                        $stmtInsert = $conn->prepare($sqlInsert);
                        $stmtInsert->bindParam(':nombre', $row['nombre']);
                        $stmtInsert->bindParam(':nombre_producto', $nombreProducto);
                        $stmtInsert->bindParam(':cantidad', $cantidad);
                        $stmtInsert->bindParam(':valor_total', $valorTotal);
                        $stmtInsert->execute();
                        echo "Factura agregada exitosamente.";
                    }
                } else {
                    echo "No se encontraron resultados para el nombre especificado.";
                }
            } catch(PDOException $e) {
                echo "Error en la conexión o consulta: " . $e->getMessage();
            }
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <input type="submit" value="Buscar" class="buscar">
            </div>
            <div>
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?php echo $nombreCliente; ?>"> 
            </div>
            <div>
                <label>Nombre de producto</label>
                <input type="text" name="nombre_producto" value="<?php echo $nombreProducto; ?>"> 
            </div>
            <div>
                <label>Cantidad</label>
                <input type="number" name="cantidad" value="<?php echo $cantidad; ?>">
            </div>
            <div>
                <label>Valor total</label>
                <input type="number" name="valor_total" value="<?php echo $valorTotal; ?>">
            </div>
            <input type="submit" name="enviar" value="Agregar">
        </form>
    </div>

</body>
</html>
