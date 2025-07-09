<?php
$conn = new mysqli("127.0.0.1", "administrador", "admin123", "proyecto");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
echo "Conexión exitosa";
?>
