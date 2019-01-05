<?php

if (isset($_POST["Login"])) {
    if (checkUserExistence($_POST["Username"]) && checkPassword($_POST["Username"], $_POST["Password"])) {
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

function displayLogin() {
    echo "<h2> ". translate("Create Account or Login") ." </h2>";

    if (get_param("reason", "") == "loginFailed") {
        echo "<h3> ". translate("Wrong Password or wrong Username") . "</h3>";
    }

    if (get_param("reason", "") == "registerSuccess") {
        echo "<h3>" .translate("Successfully created user")." </h3>";
    }

    if (get_param("reason", "") == "userAlreadyTaken") {
        echo "<h3>" .translate("This Username is already taken..."). "  </h3>";
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
    displayRegisterMenu();
}

function displaySignIn() {
    $login = new LoginForm(getLanguage(["en", "de"]), "");
    echo $login->render();
}

function checkUserExistence(string $username) {
    return !checkUsername(User::getDatabaseUsernames(), htmlspecialchars($username));
}

function checkPassword(string $username, string $password) {
    return User::getPasswordHash(htmlspecialchars($username), htmlspecialchars($password));
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
    return $html;
}
