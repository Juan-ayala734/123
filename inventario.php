<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'conexion.php';

// 1. Verificamos si el usuario envió algo por la barra de búsqueda
$busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';

if ($busqueda != '') {
    // 2. Si hay búsqueda, preparamos la consulta con LIKE para nombre o categoría
    $sql = "SELECT p.id, p.nombre_producto, c.nombre_categoria, p.stock, p.precio
            FROM productos p
            INNER JOIN categorias c ON p.categoria_id = c.id
            WHERE p.nombre_producto LIKE ? OR c.nombre_categoria LIKE ?
            ORDER BY p.id ASC";

    $stmt = $conn->prepare($sql);

    $param_busqueda = "%" . $busqueda . "%";

    $stmt->bind_param("ss", $param_busqueda, $param_busqueda);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();
} else {
    // 3. Si la barra de búsqueda está vacía, mostramos el inventario completo
    $sql = "SELECT p.id, p.nombre_producto, c.nombre_categoria, p.stock, p.precio
            FROM productos p
            INNER JOIN categorias c ON p.categoria_id = c.id
            ORDER BY p.id ASC";
    $resultado = $conn->query($sql);
}
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
    background:#f4f6f9;
    padding:20px;
}

h2{
    color:#1e293b;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    margin-top:20px;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
}

th,td{
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}

th{
    background:#3b82f6;
    color:white;
}

tr:nth-child(even){
    background:#f9f9f9;
}

tr:hover{
    background:#eef6ff;
}

.stock-bajo{
    color:red;
    font-weight:bold;
}

.btn-nuevo{
    display:inline-block;
    background:#3b82f6;
    color:white;
    padding:10px 15px;
    text-decoration:none;
    border-radius:5px;
    font-weight:bold;
    margin-bottom:15px;
}

.btn-nuevo:hover{
    background:#2563eb;
}

.btn-editar{
    background:#f59e0b;
    color:white;
    padding:6px 12px;
    text-decoration:none;
    border-radius:4px;
    font-size:13px;
    font-weight:bold;
    margin-right:5px;
}

.btn-editar:hover{
    background:#d97706;
}

.btn-eliminar{
    background:#ef4444;
    color:white;
    padding:6px 12px;
    text-decoration:none;
    border-radius:4px;
    font-size:13px;
    font-weight:bold;
}

.btn-eliminar:hover{
    background:#b91c1c;
}

</style>

</head>

<body>

<h2>Catálogo de Inventario</h2>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">

    <a href="nuevo_producto.php" class="btn-nuevo">
    ➕ Nuevo Producto
    </a>

    <!-- Formulario de Búsqueda -->
    <form method="GET" style="display: flex; gap: 10px;">
        <input type="text" name="buscar" placeholder="Buscar producto o categoría..."
               value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>"
               style="padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; width: 250px;">
        <button type="submit" style="background: #10b981; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">🔍 Buscar</button>
        <a href="inventario.php" style="background: #64748b; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;">Limpiar</a>
    </form>

</div>

<p>
Usuario:
<strong><?php echo $_SESSION['nombre']; ?></strong>
</p>

<p>
<a href="logout.php">Cerrar Sesión</a>
</p>

<table>

<thead>

<tr>
    <th>Código</th>
    <th>Producto</th>
    <th>Categoría</th>
    <th>Stock</th>
    <th>Precio</th>
    <th>Acciones</th>
</tr>

</thead>

<tbody>

<?php

if($resultado->num_rows > 0){

    while($fila = $resultado->fetch_assoc()){

        $claseStock = ($fila['stock'] < 10) ? "stock-bajo" : "";

?>

<tr>

    <td><?php echo $fila['id']; ?></td>

    <td><?php echo $fila['nombre_producto']; ?></td>

    <td><?php echo $fila['nombre_categoria']; ?></td>

    <td class="<?php echo $claseStock; ?>">
        <?php echo $fila['stock']; ?>
    </td>

    <td>
        $<?php echo number_format($fila['precio'],2); ?>
    </td>

    <td>
        <a href="editar_producto.php?id=<?php echo $fila['id']; ?>" class="btn-editar">
            ✏️ Editar
        </a>

        <a href="eliminar_producto.php?id=<?php echo $fila['id']; ?>"
        class="btn-eliminar"
        onclick="return confirm('¿Seguro que deseas eliminar este producto?');">
            🗑️ Eliminar
        </a>
    </td>

</tr>

<?php

    }

}else{

?>

<tr>
    <td colspan="6">
        No hay productos registrados.
    </td>
</tr>

<?php

}

?>

</tbody>

</table>

</body>
</html>