<?php

if (isset($_POST["register"])) {
    if (checkUsername(User::getDatabaseUsernames(), $_POST["Username"])) {
        doRegistration();
    } else {
        displayUserAlreadyTaken();
    }



}

function checkUsername($queryResult, $username) {
    while($row = mysqli_fetch_row($queryResult)) {
        if ($row[0] == $username){
            return false;
        }
    }
    return true;
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

}