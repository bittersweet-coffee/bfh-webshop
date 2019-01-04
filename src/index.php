<?php


    include 'php/utils/functions.php';
    include 'php/database/database.php';
    include 'php/products/Product.php';
    include 'php/utils/Form.php';
    include 'php/customer/Customer.php';
    include 'php/user/user.php';
    include 'php/utils/Nav.php';
    //include 'php/mail/mail.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require 'php/utils/Translator.php';
    require 'html/head.html';
    $nav = new Nav(getLanguage(["en", "de"]));?>

<body>
    <header>
    </header>
    <?php echo $nav->render();?>
    <div id="content">
        <img src="img/logo.png" alt="Logo" id="logo">
        <?php echo getPageContent("page"); ?>
    </div>
    <footer>Footer</footer>
    <script src="js/script.js"></script>
</body>
</html>
