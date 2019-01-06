<?php

function displayUserArea() {
    $usermodel = new UserareaModel($_SESSION['user']);
    $userview = new UserareaView($usermodel);
    $usercontroller = new UserareaController($usermodel);
    $func = get_param("action", "none");
    $usercontroller->{$func}();
    if (isset($_POST["post_changeUserData"])) {
        $usercontroller->changePassword($_POST["Oldpassword"], $_POST["Newpassword"]);
    }
    if (isset($_POST["post_changeCustomerData"])) {
        $usercontroller->changeCustomer(
            $_POST["Firstname"],
            $_POST["Lastname"],
            $_POST["Address"],
            $_POST["PostalCode"],
            $_POST["Email"],
            $_POST["Country"]);
    }
    if (isset($_POST["post_addProduct"])) {
        $usercontroller->addProductToDB(
            $_POST["addP"],
            $_POST["ProductnameEN"],
            $_POST["ProductnameDE"],
            $_POST["Price"],
            $_POST["DescriptionEN"],
            $_POST["DescriptionDE"]
        );
    }
    $userview->render();
}