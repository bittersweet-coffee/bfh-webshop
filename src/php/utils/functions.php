<?php

function getPageContent($content) {
    include 'php/utils/login.php';
    include 'php/utils/validate.php';
    $productHandler = new ProductHandler();
    switch ((isset($_GET[$content]) ? $_GET[$content] : '')) {
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

        default:
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
        if (isset($_GET["lang"]) && ($_GET["lang"]) == $key) {
            return $_GET["lang"];
        }
    }
    return $default;
}

function translate(string $str) {
    $translator = new Translator(getLanguage(["en", "de"]));
    return $translator->t($str);
}

function getProduct() {
    $productName = $_GET['product'];
    $productData = Product::getSingleProduct($_GET['lang'], $_GET['product']);
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
    $form->setCustomerInputTag("text", "Firstname");
    $form->setCustomerInputTag("text", "Lastname");
    $form->setCustomerInputTag("text", "Address");
    $form->setCustomerInputTag("text", "PostalCode");
    $form->setCustomerInputTag("email", "Email");
    $form->setCustomerInputTag("text", "Country");
    echo $form->render();
}

function displayConfirmation() {
    $form = new ConfirmationForm(getLanguage(["en", "de"]), "");
    echo $form->render();
}

function displayLogin() {
    echo "<h1> Create Account or Login </h1>";
    if (isset($_GET["reason"]) && $_GET["reason"] == "loginFailed") {
        echo "<h3> Wrong Password or wrong Username</h3>";
    }
    include 'php/utils/registration.php';
}

function displayRegister() {
    $registerForm = new RegisterForm(getLanguage(["en", "de"]), "login");
    $registerForm->setUserInputTag("text", "Username");
    $registerForm->setUserInputTag("password", "Password");
    $registerForm->setUserInputTag("password", "Retype");
    $registerForm->setUserInputTag("text", "Firstname");
    $registerForm->setUserInputTag("text", "Lastname");
    $registerForm->setUserInputTag("text", "Address");
    $registerForm->setUserInputTag("text", "PostalCode");
    $registerForm->setUserInputTag("email", "Email");
    $registerForm->setUserInputTag("text", "Country");
    echo $registerForm->render();
}

function displaySignIn() {
    $login = new LoginForm(getLanguage(["en", "de"]), "");
    $login->setUserInputTag("text", "Username");
    $login->setUserInputTag("password", "Password");
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