<?php

function getPageContent($content) {
    if (checkLogin()) {
        $username = $_SESSION['user']['username'];
        echo "<p>" . translate("You are currently logged in as") .": '$username'</p>";
    }
    $productHandler = new ProductHandler();
    switch (get_param($content,'')) {
        case 'rods':
            $productHandler->setupProducts('Fishing Rods', getLanguage(["en", "de"]));
            break;
        case 'reels':
            $productHandler->setupProducts('Reels', getLanguage(["en", "de"]));
            break;
        case 'lures':
            $productHandler->setupProducts('Lures', getLanguage(["en", "de"]));
            break;
        case 'lines':
            $productHandler->setupProducts('Fishing Lines', getLanguage(["en", "de"]));
            break;
        case 'accessories':
            $productHandler->setupProducts('Accessories', getLanguage(["en", "de"]));
            break;
        case 'about':
            if (getLanguage(["en", "de"]) == "de") {
                echo "<h2> Sinn und Zweck dieser Webseite </h2>";
                echo "<p> Dieser Webshop wurde im Rahmen eines Modules 
                           an der Berner Fachhochschule erstellt. 
                           Er dient dem alleinigen Zweck des Lernens und alle 
                           dabei erstellten Produkte und Möglichkeiten hier auf der 
                           Shop Webseite sind erfunden und teil einer Aufgabe gewesen.
                     </p>";
            } else {
                echo "<h2> Purpose of this website </h2>";
                echo "<p> This webshop was created as part of a module at the 
                          Bern University of Applied Sciences. It serves the 
                          sole purpose of learning and all products and 
                          possibilities created here on the shop website have 
                          been invented and part of a task.
                     </p>";
            }
            break;
        case 'login':
            displayLogin();
            break;
        case 'logout':
            displayLogout();
            break;
        case 'userarea':
            if (checkLogin()) {
                include 'php/user/userarea.php';
                displayUserArea();
            } else {
                displayNoAccess();
            }
            break;
        case 'buy':
            displayBuy();
            break;
        case 'shipping':
            displayShipping();
            break;
        case 'register':
            displayRegisterFrom();
            break;
        case 'sign_in':
            if (checkLogin()) {
                echo "<h2>" . translate("You have to log out first...") ." </h2>";
                echo displayLogoutMenu();
            } else {
                displaySignIn();
            }
            break;
        case 'confirmation':
            displayConfirmation();
            break;
        case 'cart':
            $cart = $_SESSION["cart"];
            echo $cart->render_form();
            break;
        case 'errorPage':
            displayErrorReason(get_param("reason", "Unknown"));
            break;
        default:
            if (checkLogin()) {
                $username = $_SESSION['user']['username'];
                echo "<h3> ". translate("Welcome") ." $username</h3>";
            }
            $productHandler->setupProducts('Fishing Rods', getLanguage(["en", "de"]));
            $productHandler->setupProducts('Reels', getLanguage(["en", "de"]));
            $productHandler->setupProducts('Lures', getLanguage(["en", "de"]));
            $productHandler->setupProducts('Fishing Lines', getLanguage(["en", "de"]));
            $productHandler->setupProducts('Accessories', getLanguage(["en", "de"]));
            break;
    }
    $productHandler->renderAllProducts();
}
function getLanguage($lang) {
    $default = "en";
    foreach ($lang as $key => $l) {
        if (get_param("lang","en") == $key) {
            return get_param("lang", "en");
        }
    }
    return $default;
}

function translate(string $str) {
    $translator = new Translator(getLanguage(["en", "de"]));
    return $translator->t($str);
}

function getProduct() {
    $lang = htmlspecialchars(get_param("lang", "en"));
    $prodName = htmlspecialchars(get_param("product",""));
    $productData = Product::getSingleProduct($lang,$prodName);
    $product = new Product($productData["realName"],
                $productData["name"],
                $productData["price"],
                $productData["descr"]);
    return $product;
}

function displayBuy() {
    $form = new BuyForm(getLanguage(["en", "de"]), "shipping");
    echo $form->render();
}

function displayShipping(){
    $form = new ShippingForm(getLanguage(["en", "de"]), "confirmation");
    echo $form->render();
}

function displayConfirmation() {
    $form = new ConfirmationForm(getLanguage(["en", "de"]), "");
    echo $form->render();
}

function checkUsername($queryResult, $username) {
    while($row = mysqli_fetch_row($queryResult)) {
        if ($row[0] == $username){
            return false;
        }
    }
    return true;
}

function displayErrorReason(string $reason) {
    $error = new ErrorPage($reason);
    echo $error->render();
}

function displayLogout(){
    echo displayLogoutMenu();
}

function createErrorUrl($reason) {
    $loc = "Location: ";
    $url = htmlspecialchars($_SERVER['PHP_SELF']);
    $url = add_param($url, "lang", getLanguage(["en", "de"]));
    $url = add_param($url, "page", "errorPage");
    $url = add_param($url,"reason", $reason);
    $url =  $loc . $url;
    header($url);
}

function get_param($name, $default) {
    if (!isset($_GET[$name]))
        return $default;
    $name_get = htmlspecialchars($_GET[$name]);
    return urldecode($name_get);
}

function add_param($url, $name, $value) {
    if(strpos($url, '?') !== false)
        $sep = '&';
    else
        $sep = '?';
    return $url . $sep . $name . "=" . urlencode($value);
}

function checkCookie($id) {
    if (isset($_COOKIE[$id])) {
        return $_COOKIE[$id];
    }
    return '';
}

function checkUserSession(string $name) {
    if (checkLogin()) {
        $name = strtolower($name);
        return $_SESSION['user'][$name];
    }
    return "";
}

function checkLogin() {
    return (isset($_SESSION['login']) && $_SESSION['login'] == true);
}

function checkAdmin() {
    return checkLogin() && isset($_SESSION['admin']) && $_SESSION['admin'] == true;
}

function displayNoAccess() {
    echo "<h1>" . translate("No Access") . "</h1>";
    echo "<p>" . translate("No access. Please log in first.") . "</p>";
    displaySignIn();
}


