<?php
function getPageContent($name) {
    switch ((isset($_GET[$name]) ? $_GET[$name] : '')) {
        case 'rods':
            echo "<p> rods </p>";
            displayProducts();
            break;
        case 'reels':
            echo "<p> reels </p>";
            break;
        case 'lures':
            echo "<p> lures </p>";
            break;
        case 'lines':
            echo "<p> lines </p>";
            break;
        case 'accessories':
            echo "<p> accessories </p>";
            break;
        case 'about':
            echo "<p> about </p>";
            break;
        case 'login':
            echo "<p> login </p>";
            break;
        default:
            displayProducts();
            break;
    }
}
function displayNav($pages, $language) {
    echo "<nav><ul>";
    $lang=getLanguage($language);
    $urlbase = $_SERVER['PHP_SELF'] . "?lang=$lang";
    foreach ($pages as $page) {
        $url = $urlbase . "&page=$page[1]";
        echo "<li class=\"$page[0]\"><a href=\"$url\" alt=\"$page[1]\">$page[2]</a></li>";
    }
    if (isset($_GET["page"])) {
        $urlen = $_SERVER['PHP_SELF'] . "?lang=en" . "&page=" . $_GET["page"];
        $urlde = $_SERVER['PHP_SELF'] . "?lang=de" . "&page=" . $_GET["page"];
        echo "<li class=\"nav-right\"><a href=\"$urlen\" alt=\"English\">English</a></li>";
        echo "<li class=\"nav-right\"><a href=\"$urlde\" alt=\"Deutsch\">Deutsch</a></li>";
    } else {
        $urlen = $_SERVER['PHP_SELF'] . "?lang=en";
        $urlde = $_SERVER['PHP_SELF'] . "?lang=de";
        echo "<li class=\"nav-right\"><a href=\"$urlen\" alt=\"English\">English</a></li>";
        echo "<li class=\"nav-right\"><a href=\"$urlde\" alt=\"Deutsch\">Deutsch</a></li>";
    }
    echo "</nav></ul>";
}

function getLanguage($lang) {
    foreach ($lang as $l) {
        if (isset($_GET["lang"]) and $l == $_GET["lang"]) {
            return $l;
        }
    }
    return $lang[0];

}

function getProducts() {
    $lines = file("content/products.txt");
    $products = array();
    foreach ($lines as $line) {
        $product = explode(";", $line);
        $key = $product[0];
        $value = array($product[1], $product[2]);
        $products[$key] = $value;
    }
    return $products;
}

function displayProducts() {
    $products = getProducts();
    echo "<div id='container'>";
    foreach ($products as $key => $product) {
        echo "<div id='box'>
                <p>Name:$key</p>
                <p>ID: $product[0]</p>
                <p>Description: $product[1]</p>
            </div>";
    }
    echo "</div>";
}