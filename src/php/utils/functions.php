<?php
function getPageContent($name) {
    switch ((isset($_GET[$name]) ? $_GET[$name] : '')) {
        case 'rods':
            echo "<p> rods </p>";
            break;
        default:
            displayProducts();
            break;
    }
}
function displayNav($pages) {
    echo "<nav><ul>";
    foreach ($pages as $page) {
        echo "<li class=\"$page[0]\"><a href=\"index.php?page=$page[1]\" alt=\"$page[1]\">$page[2]</a></li>";
    }
    echo "</nav></ul>";
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