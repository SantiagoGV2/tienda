<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT pro_id, pro_img, pro_descripcion, pro_info, pro_precio, pro_stock FROM productos WHERE pro_stock=10");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/styles.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <title>Tienda</title>
</head>

<body>
    <header>

    </header>
    <main>
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

                        <a href="./pago.php"><button type="button" class="btn-buy">Comprar Ahora</button></a>

                        <i class="fa-solid fa-x" id="cart-close"></i>
                    </div>
                </div>
            </nav>
        </header>

        <section class="shop container">
            <h2 class="section-title">Nuestros Productos</h2>

            <div class="shop-content">
                <?php
                foreach ($resultado as $row) {
                ?>
                    <div class="product-box">
                        <?php
                        $id = $row['pro_id'];
                        $imagen = "./assets/img/" . $id . "/claro.png";

                        if(!file_exists($imagen)){
                            $imagen="./assets/no-photo.png";
                        }
                        ?>
                        <img src="<?php echo $imagen; ?>"class="product-img">
                        <h2 class="product-title"><?php echo $row['pro_descripcion']; ?></h2>
                        <span class="product-price">$ <?php echo number_format( $row['pro_precio'], 2, '.', '.'); ?></span>
                        <i class="fa-solid fa-cart-shopping add-cart"></i>
                        <h3>Cantidad: <span class="product-price"><?php echo $row['pro_stock']; ?></span></h3>
                        <a href="details.php?id=<?php echo  $row['pro_id'];?>&token=<?php echo hash_hmac('sha1', $row['pro_id'], KEY_TOKEN );?>"><button>Detalles</button></a>
                    </div>       
                <?php
                }
                ?>
            </div>
        </section>
    </main>
    <footer></footer>
    <script src="./js/app_tienda.js"></script>
    <script src="https://kit.fontawesome.com/1acde824b3.js" crossorigin="anonymous"></script>
    
</body>

</html>