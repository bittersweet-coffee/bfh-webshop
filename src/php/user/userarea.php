<?php

function displayUserArea() {
    $usermodel = new UserareaModel($_SESSION['user']);
    $userview = new UserareaView($usermodel);
    $usercontroller = new UserareaController($usermodel);
    $func = get_param("action", "none");
    if (method_exists($usercontroller ,$func)) {
        $usercontroller->{$func}();
    } else {
        $usercontroller->none();
    }
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
            $_POST["Prod"],
            $_POST["ProductnameEN"],
            $_POST["ProductnameDE"],
            $_POST["Price"],
            $_POST["DescriptionEN"],
            $_POST["DescriptionDE"]
        );
    }

    if (isset($_POST["post_deleteProduct"])) {
        $usercontroller->deleteProductsFromDB($_POST['Prod']);
    }

    if (isset($_POST["post_searchProduct"])) {
        $usercontroller->updateProduct($_POST['Prod'], true);
    }
    if (isset($_POST["post_updateProduct"])) {
        $usercontroller->updateProd(
            $_SESSION['old_name'],
            $_POST["ProductnameEN"],
            $_POST["ProductnameDE"],
            $_POST["Price"],
            $_POST["DescriptionEN"],
            $_POST["DescriptionDE"]
        );
    }
    $userview->render();
}