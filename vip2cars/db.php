<?php
$conn = new mysqli("localhost", "root", "", "vip2cars_db");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

