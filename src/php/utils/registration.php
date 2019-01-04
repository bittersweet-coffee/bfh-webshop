<?php

if (isset($_POST["register"])) {
    if (checkUsername(User::getDatabaseUsernames(), htmlspecialchars($_POST["Username"]))) {
        doRegistration();
        echo "<h3> Successfully created user </h3>";
        displayMainMenu();
    } else {
        displayUserAlreadyTaken();
    }
} else {
    displayMainMenu();
}

function doRegistration() {
    $customer = new Customer(
        $_SESSION["Firstname"],
        $_SESSION["Lastname"],
        $_SESSION["Address"],
        $_SESSION['PostalCode'],
        $_SESSION["Email"],
        $_SESSION["Country"]);
    //$_SESSION['customer'] = $customer;
    $user = new User($customer, $_POST["Username"], $_POST["Password"]);
    $user->storeUser();
}

function displayUserAlreadyTaken() {

    echo "<h2>" .translate("This Username is already taken..."). "  </h2>";
    displayRegister();
}

function displayMainMenu() {
    $lang = getLanguage(["en", "de"]);
    $page = "register";
    $url = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $lang);
    $url = add_param($url, "page", $page);
    $html = "<a href='$url' class='button'>" . translate("Register") . "</a>";
    $page = "sign_in";
    $url = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $lang);
    $url = add_param($url, "page", $page);
    $html = $html . "<a href='$url' class='button'>" . translate("Sign in") . "</a>";
    echo $html;
}