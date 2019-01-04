<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// BUY-FORMS validation
if (isset($_POST["buy"])) {
    if (!isset($_POST["amount"]) and !isset($_POST["donation"])) {
        displayErrorPage("validationFailed");
    }
    if ($_POST["amount"] < 0) {
        displayErrorPage("validationFailed");
    }
    $loc = "Location: ";
    $uri = $_SERVER['REQUEST_URI'];
    $uri = add_param($uri,"amount",htmlspecialchars($_POST["amount"]));
    $uri = add_param($uri,"donation",htmlspecialchars($_POST["donation"]));
    $url =  $loc . $uri;
    header($url);
}

if (isset($_POST["shipping"])) {
    if (checkCustomerData() && checkPayment()) {
        checkComment();
        createCustomer();
        createPayment();
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
    setCustomerCookies();
    return true;
}

function setCustomerCookies() {
    setcookie("Firstname", htmlspecialchars($_POST["Firstname"]));
    setcookie("Lastname", htmlspecialchars($_POST["Lastname"]));
    setcookie("Address", htmlspecialchars($_POST["Address"]));
    setcookie("PostalCode", htmlspecialchars($_POST["PostalCode"]));
    setcookie("Email", htmlspecialchars($_POST["Email"]));
    setcookie("Country", htmlspecialchars($_POST["Country"]));
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
