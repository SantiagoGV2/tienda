<?php
require 'config/config.php';
require 'config/database.php';

// Suponiendo que KEY_TOKEN esté definida en config.php
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    echo 'Error al procesar la peticion1';
    exit;
} else {

    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {

        $sql = $con->prepare("SELECT count(pro_id) FROM productos WHERE pro_id=? AND pro_stock=10");
        $sql->execute([$id]);

        if ($sql->fetchColumn() > 0) {
            $sql = $con->prepare("SELECT pro_id, pro_img, pro_descripcion, pro_info, pro_precio, pro_stock FROM productos WHERE pro_id=? AND pro_stock=10 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            $id2 = $row['pro_id'];
            $img = $row['pro_img'];
            $descripcion = $row['pro_descripcion'];
            $info = $row['pro_info'];
            $precio = $row['pro_precio'];
            $stock = $row['pro_stock'];
            $dir_images = "./assets/img/" . $id . "/";

            $ruta_img = $dir_images . 'claro.png';

            if (!file_exists($ruta_img)) {
                $ruta_img = "/assets/no-photo.png";
            }

            $imagenes = array();
            if (file_exists($dir_images)) {
                $dir = dir($dir_images);

                while (($archivo = $dir->read()) != false) {
                    if ($archivo != 'claro.png' && (strpos($archivo, 'png') || strpos($archivo, 'jpeg'))) {
                        $imagenes[] = $dir_images . $archivo;
                    }
                }
                $dir->close();
            }
        } else {
            echo 'Error al procesar la peticion3';
            exit;
        }
    } else {
        echo 'Error al procesar la peticion2';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/styles.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <title>Tienda</title>
</head>

<body>


    <header class="header">
        <nav>
            <div class="wrapper">
                <div class="logo">
                    <a href="/pages/index.html"><img src="./assets/img/3/claro.png" alt="logo"></a>
                </div>
                <input type="radio" name="slider" id="menu-btn">
                <input type="radio" name="slider" id="close-btn">
                <ul class="nav-links">
                    <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                    <li>
                        <a href="index.html" class="desktop-item">Sobre Nosotros</a>
                        <input type="checkbox" id="showDrop">
                        <label for="showDrop" class="mobile-item">Sobre Nosotros</label>
                        <ul class="drop-menu">
                            <li><a href="index.html">Información</a></li>
                            <li><a href="index.html">Misión y Visión</a></li>
                            <li><a href="index.html">Objetivos y Valores</a></li>
                            <li><a href="index.html">Servicios</a></li>
                            <li><a href="index.html">Contacto</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="tienda.html" class="desktop-item">Tienda</a>
                        <input type="checkbox" id="showMega">
                        <label for="showMega" class="mobile-item">Tienda</label>
                        <div class="mega-box">
                            <div class="content">
                                <div class="row">
                                    <img src="/assets/img/shopping.jpg" alt="">
                                </div>
                                <div class="row">
                                    <h1>Equipos Fibra Óptica</h1>
                                    <ul class="mega-links">
                                        <li><a href="#">Impalmadoras</a></li>
                                        <li><a href="#">Power mitter</a></li>
                                        <li><a href="#">Provadores de luz</a></li>
                                    </ul>
                                </div>
                                <div class="row">
                                    <h1>Herramientas Fibra Óptica</h1>
                                    <ul class="mega-links">
                                        <li><a href="#">Stripp</a></li>
                                        <li><a href="#">Cortadoras</a></li>
                                        <li><a href="#">Kit Completo</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a href="politicas.html">Politicas</a></li>
                    <li><a href="tipo_trabajo.html">Tipos de trabajo</a></li>
                </ul>
                <i class="fa-solid fa-cart-shopping" id="carrito"></i>
                <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
                <!----CARRITO-->
                <div class="cart">
                    <h2 class="cart-title">Tu Carrito</h2>
                    <div class="cart-content">

                    </div>

                    <div class="total">
                        <div class="total-title">Total</div>
                        <div class="total-price">$0</div>
                    </div>

                    <button type="button" class="btn-buy">Comprar Ahora</button>

                    <i class="fa-solid fa-x" id="cart-close"></i>
                </div>
            </div>
        </nav>
    </header>