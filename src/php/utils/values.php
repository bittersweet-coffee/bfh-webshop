<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["Firstname"])) {
    $_SESSION['Firstname'] = $_POST['Firstname'];
    setcookie('Firstname', $_POST['Firstname']);
}

if (isset($_POST["Lastname"])) {
    $_SESSION['Lastname'] = $_POST['Lastname'];
    setcookie('Lastname', $_POST['Lastname']);
}

if (isset($_POST["Email"])) {
    $_SESSION['Email'] = $_POST['Email'];
    setcookie('Email', $_POST['Email']);
}

if (isset($_POST["Address"])) {
    $_SESSION['Address'] = $_POST['Address'];
    setcookie('Address', $_POST['Address']);

}

if (isset($_POST["Country"])) {
    $_SESSION['Country'] = $_POST['Country'];
    setcookie('Country', $_POST['Country']);
}

if (isset($_POST["PostalCode"])) {
    $var = intval($_POST['PostalCode']);
    $_SESSION['PostalCode'] = $var;
    setcookie('PostalCode', $var);
}

if (isset($_GET['product'])) {
    $_SESSION['product'] = $_SESSION[$_GET['product']];
}

if (isset($_POST["donation"])) {
    $_SESSION['donation'] = $_POST['donation'];
}

if (isset($_POST["number"])) {
    $_SESSION['amount'] = $_POST['number'];
}

if (isset($_POST["payment"])) {
    $_SESSION['payment'] = $_POST['payment'];
}

if (isset($_POST["card_name"])) {
    $_SESSION['card_name'] = $_POST['card_name'];
}

if (isset($_POST["card_number"])) {
    $_SESSION['card_number'] = $_POST['card_number'];
}

if (isset($_POST["card_cvv"])) {
    $_SESSION['card_cvv'] = $_POST['card_cvv'];
}

if (isset($_POST["bill_firstname"])) {
    $_SESSION['bill_firstname'] = $_POST['bill_firstname'];
}

if (isset($_POST["bill_lastname"])) {
    $_SESSION['bill_lastname'] = $_POST['bill_lastname'];
}

if (isset($_POST["bill_address"])) {
    $_SESSION['bill_address'] = $_POST['bill_address'];
}

if (isset($_POST["bill_postalCode"])) {
    $_SESSION['bill_postalCode'] = $_POST['bill_postalCode'];
}

if (isset($_POST["bill_country"])) {
    $_SESSION['bill_country'] = $_POST['bill_country'];
}

if (isset($_POST["comment"])) {
    $_SESSION['comment'] = $_POST['comment'];
}