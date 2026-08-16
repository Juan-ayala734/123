<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'conexion.php';

// MÉTRICA 1: Total de productos
$res_total = $conn->query("SELECT COUNT(id) AS cantidad FROM productos");
$fila_total = $res_total->fetch_assoc();
$total_productos = $fila_total['cantidad'];

// MÉTRICA 2: Capital del inventario
$res_valor = $conn->query("SELECT SUM(precio * stock) AS capital FROM productos");
$fila_valor = $res_valor->fetch_assoc();
$capital_inventario = $fila_valor['capital'] ? $fila_valor['capital'] : 0;

// MÉTRICA 3: Producto más caro
$res_caro = $conn->query("SELECT MAX(precio) AS max_precio FROM productos");
$fila_caro = $res_caro->fetch_assoc();
$precio_maximo = $fila_caro['max_precio'] ? $fila_caro['max_precio'] : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Control - Sistema de Ventas</title>

<style>
body{
    font-family: Arial, sans-serif;
    background:#f1f5f9;
    margin:0;
    padding:20px;
}

.navbar{
    background:#1e293b;
    color:white;
    padding:15px 25px;
    border-radius:8px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.btn-salir{
    background:#ef4444;
    color:white;
    text-decoration:none;
    padding:8px 15px;
    border-radius:5px;
}

.tarjetas-container{
    display:flex;
    gap:20px;
    margin-bottom:30px;
}

.tarjeta{
    flex:1;
    background:white;
    padding:25px;
    border-radius:8px;
    text-align:center;
    box-shadow:0 2px 6px rgba(0,0,0,.1);
    border-top:5px solid #3b82f6;
}

.verde{
    border-top-color:#10b981;
}

.naranja{
    border-top-color:#f59e0b;
}

.numero{
    font-size:32px;
    font-weight:bold;
}

.menu-modulos{
    display:flex;
    gap:20px;
}

.modulo{
    flex:1;
    background:#3b82f6;
    color:white;
    text-decoration:none;
    text-align:center;
    padding:20px;
    border-radius:8px;
}
</style>

</head>

<body>

<div class="navbar">

<h2>
Bienvenido,
<?php echo $_SESSION['nombre']; ?>

<br>

<small>
Rol:
<?php echo $_SESSION['rol']; ?>
</small>

</h2>

<a href="logout.php" class="btn-salir">
Cerrar Sesión
</a>

</div>

<div class="tarjetas-container">

<div class="tarjeta">
<h3>Total Productos</h3>
<p class="numero"><?php echo $total_productos; ?></p>
</div>

<div class="tarjeta verde">
<h3>Capital Inventario</h3>
<p class="numero">
$<?php echo number_format($capital_inventario,2); ?>
</p>
</div>

<div class="tarjeta naranja">
<h3>Producto Más Caro</h3>
<p class="numero">
$<?php echo number_format($precio_maximo,2); ?>
</p>
</div>

</div>

<h2>Módulos del Sistema</h2>

<div class="menu-modulos">

<a href="inventario.php" class="modulo">
📦 Inventario
</a>

<a href="proveedores.php" class="modulo" style="background:#8b5cf6;">
🚚 Módulo de Proveedores
</a>

<a href="#" class="modulo" style="background:#64748b;">
🛒 Punto de Venta
</a>

</div>

</body>
</html>