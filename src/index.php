<?php
    include 'php\utils\functions.php';
    $pages = array(
        "rods" => array("nav-left", "rods", "Fishing Rods"),
        "reels" => array("nav-left", "reels", "Reels"),
        "lures" => array("nav-left", "lures","Lures"),
        "lines" => array("nav-left", "lines","Fishing Lines"),
        "accessories" => array("nav-left", "accessories","Accessories"),
        "about" => array("nav-left", "about","About"),
        "login" => array("nav-right", "login","Login"),
        "#en" => array("nav-right", "#en","English"),
        "#de" => array("nav-right", "#de","Deutsch")
    );
    require 'html/head.html';?>

<body>
    <header>
    </header>
    <?php displayNav($pages); ?>
    <div id="content">
        <img src="img/logo.png" alt="Logo" id="logo">
        <?php echo getPageContent("page"); ?>
    </div>
    <footer>Footer</footer>
    <script src="js/script.js"></script>
</body>
</html>