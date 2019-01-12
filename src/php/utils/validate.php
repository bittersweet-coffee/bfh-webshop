<?php

// BUY-FORMS validation
if (isset($_POST["buy"])) {
    if (!isset($_POST["amount"]) and !isset($_POST["donation"])) {
        createErrorUrl("validationFailed");
    }
    if ($_POST["amount"] <= 0) {
        createErrorUrl("amountBelowZero");
    } else {
        $loc = "Location: ";
        $uri = $_SERVER['REQUEST_URI'];
        $uri = add_param($uri,"amount",htmlspecialchars($_POST["amount"]));
        $uri = add_param($uri,"donation",htmlspecialchars($_POST["donation"]));
        $url =  $loc . $uri;
        header($url);
    }
}

if (isset($_POST["shipping"])) {
    if (checkCustomerData() && checkPayment()) {
        checkComment();
        createCustomer();
        createPayment();
    } else {
        createErrorUrl("validationFailed");
    }
}

function checkCustomerData() {
    if (!isset($_POST["Firstname"]) ||
        !isset($_POST["Lastname"])  ||
        !isset($_POST["Email"])     ||
        !isset($_POST["Address"])   ||
        !isset($_POST["Country"])   ||
        !isset($_POST["PostalCode"])) {
       return false;
    }
    $f = htmlspecialchars($_POST["Firstname"]);
    $l = htmlspecialchars($_POST["Lastname"]);
    $e = htmlspecialchars($_POST["Email"]);
    $a = htmlspecialchars($_POST["Address"]);
    $c = htmlspecialchars($_POST["Country"]);
    $p = htmlspecialchars($_POST["PostalCode"]);
    if (!preg_match('/[A-Za-z]+\d*\s*[A-Za-z]*\d*/', $f) &&
        !preg_match('/[A-Za-z]+\d*\s*[A-Za-z]*\d*/', $l) &&
        !preg_match('/^.+@.+\..+$/', $e) &&
        !preg_match('/^[A-Za-z]+\d*\s*\d*[A-Za-z]*\d*[A-Za-z]*$/', $a) &&
        !preg_match('/^\d{4}$/', $c) &&
        !preg_match('/^[A-Za-z]{2}$/', $p)
    ) {
        return true;
    } else {
        return false;
    }

    setCustomerCookies();
    return true;
}

if (isset($_POST["register"])) {
    if (!checkCustomerData()){
        createErrorUrl("registrationFailed: Customerdata");
    } elseif(!checkUserData()) {
        createErrorUrl("registrationFailed: Userdata");
    } else {
        createCustomer();
        createUser();
    }
}

function createUser() {
    $user = new User($_SESSION['customer'],
        htmlspecialchars($_POST["Username"]),
        htmlspecialchars($_POST["Password"]));
    $_SESSION['user'] = $user;
}

function checkUserData() {
    if (!isset($_POST["Username"])   ||
        !isset($_POST["Password"]) ||
        !isset($_POST["Retype"])) {
        return false;
    }
    $p = htmlspecialchars($_POST["Password"]);
    $rt= htmlspecialchars($_POST["Retype"]);
    if ($p !== $rt) {
        return false;
    }
    $u = htmlspecialchars($_POST["Username"]);
    if (!preg_match('/[^A-Za-z0-9]/', $u)) {
        return true;
    }
    return false;
}

function setCustomerCookies() {
    setcookie("Firstname", htmlspecialchars($_POST["Firstname"]), time()+300);
    setcookie("Lastname", htmlspecialchars($_POST["Lastname"]), time()+300);
    setcookie("Address", htmlspecialchars($_POST["Address"]), time()+300);
    setcookie("PostalCode", htmlspecialchars($_POST["PostalCode"]), time()+300);
    setcookie("Email", htmlspecialchars($_POST["Email"]), time()+300);
    setcookie("Country", htmlspecialchars($_POST["Country"]), time()+300);
}

function createCustomer() {
    $customer = new Customer(
        htmlspecialchars($_POST["Firstname"]),
        htmlspecialchars($_POST["Lastname"]),
        htmlspecialchars($_POST["Address"]),
        htmlspecialchars($_POST["PostalCode"]),
        htmlspecialchars($_POST["Email"]),
        htmlspecialchars($_POST["Country"]));
    $_SESSION['customer'] = $customer;
}

function checkPayment() {
    if (!isset($_POST["payment"])) {
        return false;
    } else if($_POST["payment"] == "card"){
        return checkCardPayment();
    } else if ($_POST["payment"] == "paper") {
        return checkPaperPayment();
    } else {
        return false;
    }
}

function checkCardPayment() {
    if (!isset($_POST["card_name"])   ||
        !isset($_POST["card_number"]) ||
        !isset($_POST["card_cvv"])) {
        return false;
    }
    return true;
}

function checkPaperPayment() {
    if (!isset($_POST["bill_firstname"])  ||
        !isset($_POST["bill_lastname"])   ||
        !isset($_POST["bill_address"])    ||
        !isset($_POST["bill_postalCode"]) ||
        !isset($_POST["bill_country"])) {
        return false;
    }
    return true;
}

function createPayment() {
    if($_POST["payment"] == "card") {
        $payment = ProductPayment::cardPayment(
            "card",
            htmlspecialchars($_POST["card_name"]),
            htmlspecialchars($_POST["card_number"]),
            htmlspecialchars($_POST["card_cvv"]));
    } else if ($_POST["payment"] == "paper") {
        $payment = ProductPayment::billPayment(
            "paper",
            htmlspecialchars($_POST["bill_firstname"]),
            htmlspecialchars($_POST["bill_lastname"]),
            htmlspecialchars($_POST["bill_address"]),
            htmlspecialchars($_POST["bill_postalCode"]),
            htmlspecialchars($_POST["bill_country"]));
    }
    $_SESSION['payment'] = $payment;
}

function checkComment() {
    if (isset($_POST["comment"])) {
        $_SESSION['comment'] = htmlspecialchars($_POST['comment']);
    }
}
