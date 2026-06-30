<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];

    $sql = "UPDATE productos
            SET nombre_producto = ?, categoria_id = ?, stock = ?, precio = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("siidi", $nombre, $categoria, $stock, $precio, $id);

    if($stmt->execute()){

        header("Location: inventario.php");
        exit();

    }else{

        echo "Error al actualizar el producto.";

    }

    $stmt->close();
    $conn->close();

}else{

    header("Location: inventario.php");
    exit();

}
?>