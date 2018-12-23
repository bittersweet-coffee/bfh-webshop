<?php

if (isset($_POST["Login"])) {
    if (checkUserExistence() && checkPassword()) {
        performLoggin($_POST["Username"], $_POST["Password"]);
        $username = $_SESSION['user']['username'];
        echo "<h3> Loggin Successfully, Welcome $username</h3>";
    } else {
        header(getLoginFailedUrl());
    }
}

function checkUserExistence() {
    return !checkUsername(User::getDatabaseUsernames(), $_POST["Username"]);
}

function checkPassword() {
    return User::getPasswordHash($_POST["Username"], $_POST["Password"]);
}

function getLoginFailedUrl() {
    $loc = "Location: ";
    //$host unused - need for tests.
    //$host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    $page = "&page=login";
    $reason = "&reason=loginFailed";
    $url =  $loc . $uri . $page . $reason;
    return $url;
}

function performLoggin(string $usr, string $pwd) {
    $customer = buildCustomer($usr);
    $user = new User($customer, $usr, $pwd);
    $_SESSION['loggin'] = true;
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
