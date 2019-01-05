<?php

if (isset($_POST["register"])) {
    if (checkUsername(User::getDatabaseUsernames(), $_SESSION['user']->getUsername())) {
        doRegistration();
        $loc = "Location: ";
        $url = htmlspecialchars($_SERVER['PHP_SELF']);
        $url = add_param($url, "lang", getLanguage(["en", "de"]));
        $url = add_param($url, "page", "login");
        $url = add_param($url,"reason", "registerSuccess");
        $url =  $loc . $url;
        header($url);
    } else {
        $loc = "Location: ";
        $url = htmlspecialchars($_SERVER['PHP_SELF']);
        $url = add_param($url, "lang", getLanguage(["en", "de"]));
        $url = add_param($url, "page", "login");
        $url = add_param($url,"reason", "userAlreadyTaken");
        $url =  $loc . $url;
        header($url);
    }
}

function displayRegisterFrom() {
    $registerForm = new RegisterForm(getLanguage(["en", "de"]), "login");
    echo $registerForm->render();
}

function displayRegisterMenu() {
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

function doRegistration() {
    $user = $_SESSION['user'];
    $user->storeUser();
}