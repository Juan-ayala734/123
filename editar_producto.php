<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'conexion.php';

// Verificar que llegue el ID
if (!isset($_GET['id'])) {
    header("Location: inventario.php");
    exit();
}

$id = $_GET['id'];

// Buscar el producto
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    header("Location: inventario.php");
    exit();
}

$producto = $resultado->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f8fafc;
    padding:20px;
}

.container{
    max-width:500px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:8px;
    box-shadow:0 4px 6px rgba(0,0,0,.1);
}

.form-group{
    margin-bottom:15px;
}

label{
    display:block;
    margin-bottom:5px;
    font-weight:bold;
}

input,select{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:5px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:10px;
    background:#f59e0b;
    color:white;
    border:none;
    border-radius:5px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#d97706;
}

.btn-volver{
    text-decoration:none;
    color:#3b82f6;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

<a href="inventario.php" class="btn-volver">
← Volver al Inventario
</a>

<h2>Editar Producto #<?php echo $producto['id']; ?></h2>

<form action="actualizar_producto.php" method="POST">

<input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

<div class="form-group">
<label>Nombre del Producto:</label>

<input
type="text"
name="nombre"
value="<?php echo $producto['nombre_producto']; ?>"
required>

</div>

<div class="form-group">

<label>Categoría:</label>

<select name="categoria" required>

<?php

$sql_cat = "SELECT id,nombre_categoria FROM categorias ORDER BY nombre_categoria ASC";

$res_cat = $conn->query($sql_cat);

while($cat = $res_cat->fetch_assoc()){

    $selected = ($cat['id'] == $producto['categoria_id']) ? "selected" : "";

    echo "<option value='".$cat['id']."' $selected>".$cat['nombre_categoria']."</option>";
}

?>

</select>

</div>

<div class="form-group">

<label>Stock:</label>

<input
type="number"
name="stock"
value="<?php echo $producto['stock']; ?>"
required>

</div>

<div class="form-group">

<label>Precio Unitario ($):</label>

<input
type="number"
name="precio"
step="0.01"
value="<?php echo $producto['precio']; ?>"
required>

</div>

<button type="submit">

Guardar Cambios

</button>

</form>

</div>

</body>
</html>