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
        case 'buy':
            echo "<p> buy </p>";
            displayBuy();
            break;
        default:
            displayProducts();
            break;
    }
}
function displayNav($pages) {
    echo "<nav><ul>";
    $lang=getLanguage($pages);
    $urlbase = $_SERVER['PHP_SELF'] . "?lang=$lang";
    foreach ($pages[$lang] as $page) {
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
    foreach ($lang as $key => $l) {
        if (isset($_GET["lang"])) {
            return $_GET["lang"];
        }
    }
    return $key;

}

function displayProducts() {
    //echo getcwd();
    $products = getProducts();
    echo "<div id='container'>";
    foreach ($products as $key => $product) {
        if (isset($_GET["lang"])) {
            $lang = $_GET["lang"];
        } else {
            $lang = "de";
        }
        $page = "buy";
        $url = $_SERVER['PHP_SELF'] . "?lang=$lang" . "&page=$page";
        echo "<div id='box'>
                <form method=\"POST\" action=$url>
                    <p>Name:$key</p>
                    <input type=\"hidden\" name=\"name\" value=\"$key\">
                    <p>ID: $product[0]</p>
                    <input type=\"hidden\" name=\"ID\" value=\"$product[0]\">
                    <p>Description: $product[1]</p>
                    <input type=\"hidden\" name=\"description\" value=\"$product[1]\">
                    <input type=\"submit\" value=\"buy\" name=\"buy\" /> 
                </form>
            </div>";
    }
    echo "</div>";
}

function getProducts()
{
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

function displayBuy() {
    if ((isset($_POST["name"]))) {
        $name = $_POST['name'];
        echo "<p> NAME: $name </p>";
    }
    if ((isset($_POST["ID"]))) {
        $ID = $_POST['ID'];
        echo "<p>ID: $ID </p>";
    }
    if ((isset($_POST["description"]))) {
         $description = $_POST['description'];
        echo "<p>DESC: $description </p>";
    }
}


