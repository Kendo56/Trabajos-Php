<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Recibidos</title>
</head>
<body>
    <h2>Datos recibidos</h2>
    <p>Nombre: <?php echo isset($_POST["nombre"]) ? htmlspecialchars($_POST["nombre"]) : 'No proporcionado'; ?></p>
    <p>Apellido: <?php echo isset($_POST["apellido"]) ? htmlspecialchars($_POST["apellido"]) : 'No proporcionado'; ?></p>
    <p>Número: <?php echo isset($_POST["numero"]) ? htmlspecialchars($_POST["numero"]) : 'No proporcionado'; ?></p>
    <p>Email: <?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : 'No proporcionado'; ?></p>
    <p>Ciudad: <?php echo isset($_POST["ciudad"]) ? htmlspecialchars($_POST["ciudad"]) : 'No seleccionada'; ?></p>
    <p>Deporte favorito: <?php echo isset($_POST["deporte"]) ? htmlspecialchars($_POST["deporte"]) : 'No seleccionado'; ?></p>
</body>
</html>
