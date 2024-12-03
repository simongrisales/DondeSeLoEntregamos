<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Casillero</title>

    <!-- Google Font -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css' rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c6f3edd3f0.js" crossorigin="anonymous"></script>
    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/indexstyle.css">
    <link rel="stylesheet" href="css/calculator.css">
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="index.html"><img src="img/logoSinFd.jpg" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="header__nav__option">
                        <nav class="header__nav__menu mobile-menu">
                            <ul>
                                <li class="active"><a href="index.html">Inicio</a></li>
                                <li><a href="about.html">Sobre nosotros</a></li>
                                <li><a href="#">Servicios</a>
                                    <ul class="dropdown">
                                        <li><a href="lockermanagement.html">¿Cómo manejar el casillero?</a></li>
                                        <li><a href="terms.html">Términos y condiciones de uso</a></li>
                                    </ul>
                                <li><a href="#">Ingresar</a>
                                    <ul class="dropdown">
                                        <li><a href="login/login.html">Iniciar sesión</a></li>
                                        <li><a href="sign-up/sign-up.html">Registrarse</a></li>
                                        <li><a href="calculator.php">Calculadora de envíos</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">Contáctanos</a></li>
                            </ul>
                        </nav>
                        <div class="header__nav__social">
                            <a href="https://wa.me/573053957993"><i class="fi fi-brands-whatsapp"></i></a>
                            <a href="https://www.instagram.com/donndeseloentregamos/"><i class="fi fi-brands-instagram"></i></a>
                            <a href="#"><i class="fi fi-brands-tik-tok"></i></a>
                            <a href="#"><i class="fi fi-brands-twitter-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <main>
    <div class="calculator">
        <h1>Calculadora</h1>
        <form action="" method="post">
            <label for="peso">Peso en libras:</label>
            <input type="number" id="peso" name="peso" step="0" min="0" required>
            
            <label for="valor_declarado">Valor declarado:</label>
            <input type="number" id="valor_declarado" name="valor_declarado" step="0" min="0" required>
            
            <input type="submit" value="Calcular">
        </form>

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $valor_libra_fijo = 4;
                $peso = $_POST['peso'];
                $valor_declarado = $_POST['valor_declarado'];
                if ($peso <= 10) {
                    $total = 20;
                } else {
                    $libras_extra = $peso - 10;
                    $total = $libras_extra * $valor_libra_fijo + 20;
                }
                if ($valor_declarado >= 200) {
                    $total += 65;
                }
                echo "<div class='result'>Valor del envío: USD $ " . number_format($total, 2) . "</div>";
            }
        ?>
    </div>
    </main>

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="footer__top__logo">
                            <a href="#"><img src="img/logoSinFd.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                    <div class="footer__top__social">
                            <a href="https://wa.me/573053957993"><i class="fi fi-brands-whatsapp"></i></a>
                            <a href="https://www.instagram.com/donndeseloentregamos/"><i class="fi fi-brands-instagram"></i></a>
                            <a href="#"><i class="fi fi-brands-tik-tok"></i></a>
                            <a href="#"><i class="fi fi-brands-twitter-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__option">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="footer__option__item">
                            <h5>Sobre nosotros</h5>
                            <p>Somos una empresa de Kissimmee, Florida, que ofrece servicio de transporte de paquetes desde Estados Unidos a Colombia.</p>
                            <a href="about.html" class="read__more">Leer más <span class="arrow_right"></span></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="footer__option__item">
                            <h5>Quiénes somos</h5>
                            <ul>
                                <li><a href="contact.html">Contáctanos</a></li>
                                <li><a href="contact.html">Ubicación</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="footer__option__item">
                            <h5>Nuestro trabajo</h5>
                            <ul>
                                <li><a href="terms.html">Términos y condiciones</a></li>
                                <li><a href="lockermanagement.html">Manejo del casillero</a></li>
                                <li><a href="calculator.php">Calculadora de envíos</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="footer__option__item">
                            <h5>Novedades</h5>
                            <p>Mantente al día con nuestras novedades. Envía tu corrreo para recibir actualizaciones sobre envíos, 
                                promociones y consejos para comprar en línea en Estados Unidos y recibir en Colombia.
                            </p>
                            <form action="newsletter.php" method="POST">
                                <input type="email" name="email" placeholder="Correo" required>
                                <button type="submit"><i class="fa-regular fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__copyright">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <!-- Link back to DondeSeLoEntregamos can't be removed. Template is licensed under CC BY 3.0. -->
                        <p class="footer__copyright__text">Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                             Todos los derechos reservados | Servicio de envíos de EE.UU. a Colombia <i class="fa-solid fa-truck-fast"></i> por <a href="https://simonxg" target="_blank">Dónde Se Lo Entregamos.</a>
                        </p>
                        <!-- Link back to DondeSeLoEntregamos can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
