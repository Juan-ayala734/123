<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'conexion.php';

$sql = "SELECT p.id, p.nombre_producto, c.nombre_categoria, p.stock, p.precio
        FROM productos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        ORDER BY p.id ASC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventario</title>

<style>
body{
    font-family: Arial, sans-serif;
    padding:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    border:1px solid #ccc;
    padding:10px;
}

th{
    background:#f2f2f2;
}

.stock-bajo{
    color:red;
    font-weight:bold;
}

.btn-eliminar{
    background-color:#ef4444;
    color:white;
    padding:6px 12px;
    text-decoration:none;
    border-radius:4px;
    font-size:13px;
    font-weight:bold;
}

.btn-eliminar:hover{
    background-color:#b91c1c;
}

</style>

</head>
<body>

<h2>Catálogo de Inventario</h2>
<a href="nuevo_producto.php"
style="
background:#3b82f6;
color:white;
padding:10px;
text-decoration:none;
border-radius:5px;">

+ Nuevo Producto

</a>

<p>
Usuario:
<strong><?php echo $_SESSION['nombre']; ?></strong>
</p>

<a href="logout.php">Cerrar Sesión</a>

<br><br>

<table>

<tr>
<th>Código</th>
<th>Producto</th>
<th>Categoría</th>
<th>Stock</th>
<th>Precio</th>
<th>Acciones</th>
</tr>

<?php

if($resultado->num_rows > 0){

    while($fila = $resultado->fetch_assoc()){

        $claseStock = ($fila['stock'] < 10) ? 'stock-bajo' : '';

?>

<tr>
<td><?php echo $fila['id']; ?></td>
<td><?php echo $fila['nombre_producto']; ?></td>
<td><?php echo $fila['nombre_categoria']; ?></td>
<td class="<?php echo $claseStock; ?>">
    <?php echo $fila['stock']; ?>
</td>
<td>$<?php echo number_format($fila['precio'],2); ?></td>
</tr>
<td>
    <a
    href="eliminar_producto.php?id=<?php echo $fila['id']; ?>"
    class="btn-eliminar"
    onclick="return confirm('¿Estás seguro de eliminar el producto: <?php echo $fila['nombre_producto']; ?>?');">

    🗑️ Eliminar

    </a>
</td>

<?php

    }

}else{

?>

<tr>
<td colspan="5">
No hay productos registrados.
</td>
</tr>

<?php } ?>

</table>

<?php
$resultado->free();
?>

</body>
</html>