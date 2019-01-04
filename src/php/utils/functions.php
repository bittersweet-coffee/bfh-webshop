<?php

function getPageContent($content) {
    include 'php/utils/login.php';
    include 'php/utils/validate.php';
    $productHandler = new ProductHandler();
    switch ((isset($_GET[$content]) ? get_param($content,'') : '')) {
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
            break;
        case 'login':
            displayLogin();
            break;
        case 'logout':
            displayLogout();
            break;
        case 'buy':
            displayBuy();
            break;
        case 'shipping':
            displayShipping();
            break;
        case 'register':
            displayRegister();
            break;
        case 'sign_in':
            displaySignIn();
            break;
        case 'confirmation':
            displayConfirmation();
            break;
        case 'errorPage':
            displayErrorReason(get_param("reason", "error"));
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

function displayLogin() {
    echo "<h1> ". translate("Create Account or Login") ." </h1>";
    if (get_param("reason", "") == "loginFailed") {
        echo "<h3> ". translate("Wrong Password or wrong Username") . "</h3>";
    }
    if (get_param("action", "") == "logout") {
        session_destroy();
        $loc = "Location: ";
        $url = htmlspecialchars($_SERVER['PHP_SELF']);
        $url = add_param($url, "lang", getLanguage(["en", "de"]));
        $url = add_param($url, "page", "login");
        $url =  $loc . $url;
        header($url);
    }
    include 'php/utils/registration.php';
}

function displayRegister() {
    $registerForm = new RegisterForm(getLanguage(["en", "de"]), "login");
    echo $registerForm->render();
}

function displaySignIn() {
    $login = new LoginForm(getLanguage(["en", "de"]), "");
    echo $login->render();
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
    displayLogoutMenu();
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

function checkLogin() {
    return (isset($_SESSION['login']) && $_SESSION['login'] == true);
}

