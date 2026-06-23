<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nuevo Producto</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f8fafc;
            padding:20px;
        }

        .container{
            max-width:500px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:8px;
            box-shadow:0 4px 6px rgba(0,0,0,0.1);
        }

        .form-group{
            margin-bottom:15px;
        }

        label{
            display:block;
            margin-bottom:5px;
            font-weight:bold;
        }

        input, select{
            width:100%;
            padding:10px;
            border:1px solid #ccc;
            border-radius:5px;
            box-sizing:border-box;
        }

        button{
            width:100%;
            padding:10px;
            background:#10b981;
            color:white;
            border:none;
            border-radius:5px;
            font-size:16px;
            cursor:pointer;
        }

        button:hover{
            background:#059669;
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

<h2>Registrar Nuevo Producto</h2>

<form action="guardar_producto.php" method="POST">

<div class="form-group">
<label>Nombre del Producto:</label>

<input
type="text"
name="nombre"
required
autocomplete="off">
</div>

<div class="form-group">

<label>Categoría:</label>

<select name="categoria" required>

<option value="">
-- Seleccione una categoría --
</option>

<?php

$sql_cat = "SELECT id, nombre_categoria
            FROM categorias
            ORDER BY nombre_categoria ASC";

$res_cat = $conn->query($sql_cat);

while($cat = $res_cat->fetch_assoc()){

echo "<option value='".$cat['id']."'>"
.$cat['nombre_categoria'].
"</option>";

}

?>

</select>

</div>

<div class="form-group">

<label>Cantidad Inicial:</label>

<input
type="number"
name="stock"
min="0"
required>

</div>

<div class="form-group">

<label>Precio Unitario ($):</label>

<input
type="number"
name="precio"
step="0.01"
min="0.01"
required>

</div>

<button type="submit">

Guardar Producto

</button>

</form>

</div>

</body>
</html>