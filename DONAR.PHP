<?php
$servername = "localhost3306";
$username = "root";
$password = "Cr2000!";
$dbname = "ORGANIZACION";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexio
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donaciones</title>
</head>
<body>
    <h2>Donar a un proyecto</h2>
    <form action="procesar_donacion.php" method="POST">
        <label for="nombre">Nombre del donante:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="cantidad">Cantidad a donar (USD):</label>
        <input type="number" step="0.01" id="cantidad" name="cantidad" required><br><br>

        <label for="proyecto">Seleccione el proyecto:</label>
        <select id="proyecto" name="proyecto" required>
            <?php
            include 'db.php';
            $sql = "SELECT id, nombre FROM proyectos";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row["id"]."'>".$row["nombre"]."</option>";
                }
            }
            ?>
        </select><br><br>

        <input type="submit" value="Donar">
    </form>
</body>
</html>

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email = $conn->real_escape_string($_POST['email']);
    $cantidad = $conn->real_escape_string($_POST['cantidad']);
    $proyecto = $conn->real_escape_string($_POST['proyecto']);

    $sql = "INSERT INTO donaciones (nombre_donante, email, cantidad, id_proyecto)
            VALUES ('$nombre', '$email', '$cantidad', '$proyecto')";

    if ($conn->query($sql) === TRUE) {
        echo "¡Gracias por tu donación!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
