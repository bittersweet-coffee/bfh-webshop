<?php
    include 'php\utils\functions.php';
    $pages = array(
        "rods" => array("nav-left", "rods.php", "Fishing Rods"),
        "reels" => array("nav-left", "reels.php", "Reels")
    );
require 'html/head.html';?>
<body>
    <header>
    </header>
    <?php
    $nav = array(
        array("nav-left", "rods", "Fishing Rods"),
        array("nav-left", "reels","Reels"),
        array("nav-left", "lures","Lures"),
        array("nav-left", "lines","Fishing Lines"),
        array("nav-left", "accessories","Accessories"),
        array("nav-left", "about","About"),
        array("nav-right", "login","Login"),
        array("nav-right", "#en","English"),
        array("nav-right", "#de","Deutsch")
    );
    echo "<nav><ul>";
    foreach ($nav as $item) {
        echo "<li class=\"$item[0]\"><a href=\"$item[1].html\" alt=\"$item[1]\">$item[2]</a></li>";
    }
    echo "</nav></ul>";
    ?>
    <div id="content">
        <?php
        ?>
        <p>Hello, world!</p>
        <img src="img/logo.png" alt="Logo" id="logo">
    </div>
    <footer>Footer</footer>
    <script src="js/script.js"></script>
</body>
</html>