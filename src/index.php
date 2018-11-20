<?php
    include 'php/utils/functions.php';
    include 'php/mail/mail.php';
    $pages = array(
        "en" => array (
            "rods" => array("nav-left", "rods", "Fishing Rods"),
            "reels" => array("nav-left", "reels", "Reels"),
            "lures" => array("nav-left", "lures","Lures"),
            "lines" => array("nav-left", "lines","Fishing Lines"),
            "accessories" => array("nav-left", "accessories","Accessories"),
            "about" => array("nav-left", "about","About"),
            "login" => array("nav-right", "login","Login")
        ),
        "de" => array (
            "Ruten" => array("nav-left", "rods", "Ruten"),
            "Rollen" => array("nav-left", "reels", "Rollen"),
            "Koeder" => array("nav-left", "lures","Koeder"),
            "Schnuere" => array("nav-left", "lines","Schnuere"),
            "Zubehoer" => array("nav-left", "accessories","Zubehoer"),
            "Ueber" => array("nav-left", "about","ueber"),
            "Anmeldung" => array("nav-right", "login","Anmeldung")
        )
    );
    require 'html/head.html';?>

<body>
    <header>
    </header>
    <?php displayNav($pages, $language); ?>
    <div id="content">
        <img src="img/logo.png" alt="Logo" id="logo">
        <?php echo getPageContent("page"); ?>
    </div>
    <footer>Footer</footer>
    <script src="js/script.js"></script>
</body>
</html>
