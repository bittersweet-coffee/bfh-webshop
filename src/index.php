<?php


    require 'autoloader.php';
    include 'php/database/Database.php';
    require 'php/languages/Translator.php';
    include 'php/customer/Customer.php';
    include 'php/user/User.php';
    include 'php/utils/functions.php';
    include 'php/products/Product.php';
    include 'php/utils/Form.php';
    include 'php/utils/validate.php';
    include 'php/utils/error.php';

    //include 'php/mail/mail.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include 'php/utils/login.php';
    include 'php/utils/registration.php';
    require 'html/head.html';
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = new ShoppingCart();
    }
    $cart = $_SESSION["cart"];
    $nav = new Nav(getLanguage(["en", "de"]));?>

<body>
    <header>
    </header>
    <?php echo $nav->render();?>
    <div id="content">
        <?php echo getPageContent("page"); ?>
    </div>
    <footer>
        <img src="img/logo.png" alt="Angelbedarf & Anderes" title="Angelbedarf & Anderes" id="logo">
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
