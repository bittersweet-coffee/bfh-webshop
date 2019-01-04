<?php

if (isset($_POST["Login"])) {
    if (checkUserExistence() && checkPassword()) {
        performLoggin(htmlspecialchars($_POST["Username"]), htmlspecialchars($_POST["Password"]));
        header("Refresh:0");
    } else {
        $loc = "Location: ";
        $url = htmlspecialchars($_SERVER['PHP_SELF']);
        $url = add_param($url, "lang", getLanguage(["en", "de"]));
        $url = add_param($url, "page", "login");
        $url = add_param($url,"reason", "loginFailed");
        $url =  $loc . $url;
        header($url);
    }
}

function checkUserExistence() {
    return !checkUsername(User::getDatabaseUsernames(), htmlspecialchars($_POST["Username"]));
}

function checkPassword() {
    return User::getPasswordHash(htmlspecialchars($_POST["Username"]), htmlspecialchars($_POST["Password"]));
}


function performLoggin(string $usr, string $pwd) {
    $customer = buildCustomer($usr);
    $user = new User($customer, $usr, $pwd);
    $_SESSION['login'] = true;
    $_SESSION['user'] = $user->toArray();
}

function buildCustomer(string $usr) {
    $customerData = Customer::getCustomer($usr);
    $customer = new Customer(
        $customerData["firstname"],
        $customerData["lastname"],
        $customerData["address"],
        $customerData["postalcode"],
        $customerData["email"],
        $customerData["country"]);
    return $customer;
}

function displayLogoutMenu() {
    $lang = getLanguage(["en", "de"]);
    $page = "login";
    $urlLogout = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $lang);
    $urlLogout = add_param($urlLogout, "page", $page);
    $urlLogout = add_param($urlLogout, "action", "logout");

    $urlCancle = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $lang);
    $html = "
        <h2>" . translate("Do you really want to log out?") . "</h2>
        <a href='$urlLogout' class='button'>" . translate("Logout") . "</a>
        <a href='$urlCancle' class='button'>" . translate("Cancle") . "</a>"
    ;
    echo $html;
}
