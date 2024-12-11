<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$dbname = 'registro';
$usuario = 'root';
$contraseña = '';

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $contraseña);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("¡Error en la conexión a la base de datos!: " . $e->getMessage());
}

// Código para inserción en la base de datos:
// Nombre de la Base de datos es: registro
// Nombre de la tabla: usuarios


// Función para insertar datos en la base de datos
function insertarUsuario($pdo, $email, $clave, $telefono) {
  try {
      $sql = "INSERT INTO usuarios (email, clave, telefono) VALUES (:email, :clave, :telefono)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':clave', $clave);
      $stmt->bindParam(':telefono', $telefono);

      if ($stmt->execute()) {
          echo "Registro exitoso.";
      } else {
          echo "Error al registrar los datos.";
      }
  } catch (PDOException $e) {
      echo "Error en la inserción de datos: " . $e->getMessage();
  }
}
//Toma de datos en el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email= htmlspecialchars(trim($_POST['email']));
    $clave = htmlspecialchars(trim($_POST['clave']));
    $telefono = htmlspecialchars(trim($_POST['telefono']));

    echo "<h1>Gracias por tu mensaje!</h1>";
    echo "<p><strong>email:</strong> " . $email . "</p>";
    echo "<p><strong>contraseña:</strong> " . $clave . "</p>";
    echo "<p><strong>telefono:</strong> " . $telefono . "</p>";

    insertarUsuario($pdo, $email, $clave, $telefono);
} else {
    echo "No se recibieron datos del formulario.";
}
?>