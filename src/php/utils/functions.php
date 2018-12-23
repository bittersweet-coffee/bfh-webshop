<?php

function getPageContent($content) {
    $t = new Translator(getLanguage(["en", "de"]));
    // Call Translator like this:
    //echo $t->t("Test");
    include 'php/utils/login.php';
    include 'php/utils/values.php';
    $productHandler = new ProductHandler();
    switch ((isset($_GET[$content]) ? $_GET[$content] : '')) {
        case 'rods':
            echo "<p> rods </p>";
            $productHandler->setupProducts('Fishing Rods', getLanguage(["en", "de"]));
            break;
        case 'reels':
            echo "<p> reels </p>";
            $productHandler->setupProducts('Reels', getLanguage(["en", "de"]));
            break;
        case 'lures':
            echo "<p> lures </p>";
            $productHandler->setupProducts('Lures', getLanguage(["en", "de"]));
            break;
        case 'lines':
            echo "<p> lines </p>";
            $productHandler->setupProducts('Fishing Lines', getLanguage(["en", "de"]));
            break;
        case 'accessories':
            echo "<p> accessories </p>";
            $productHandler->setupProducts('Accessories', getLanguage(["en", "de"]));
            break;
        case 'about':
            echo "<p> about </p>";
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

function displayNav($pages) {
    echo "<nav><ul>";
    $lang=getLanguage($pages);
    $urlbase = $_SERVER['PHP_SELF'] . "?lang=$lang";
    foreach ($pages[$lang] as $key => $page) {
        $url = $urlbase . "&page=$page[1]";
        echo "<li class='$page[0]'><a href='$url' alt='$page[1]'>$page[2]</a></li>";
    }
    foreach ($pages as $key => $l) {
        if (isset($_GET["page"])) {
            $url = $_SERVER['PHP_SELF'] . "?lang=$key" . "&page=" . $_GET["page"];
            echo "<li class='nav-right'><a href='$url' alt='$key'>";
            echo strtoupper($key) . "</a></li>";
        } else {
            $url = $_SERVER['PHP_SELF'] . "?lang=$key";
            echo "<li class='nav-right'><a href='$url' alt=''$key'>";
            echo strtoupper($key) . "</a></li>";
        }
    }
    echo "</nav></ul>";
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