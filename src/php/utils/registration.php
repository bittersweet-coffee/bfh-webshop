<?php

if (isset($_POST["register"])) {
    if (checkUsername(User::getDatabaseUsernames(), $_POST["Username"])) {
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
    $_SESSION['customer'] = $customer;
    $user = new User($customer, $_POST["Username"], $_POST["Password"]);
    $user->storeUser();
}

function displayUserAlreadyTaken() {
    echo "<h2> This Username is already taken... </h2>";
    displayRegister();
}

function displayMainMenu() {
    $lang = getLanguage(["en", "de"]);
    $page = "register";
    $url = $_SERVER['PHP_SELF'] . "?lang=$lang" . "&page=$page";
    $html = "<a href='$url' class='button'>Register</a>";
    $page = "sign_in";
    $url = $_SERVER['PHP_SELF'] . "?lang=$lang" . "&page=$page";
    $html = $html . "<a href='$url' class='button'>Sign In</a>";
    echo $html;
}