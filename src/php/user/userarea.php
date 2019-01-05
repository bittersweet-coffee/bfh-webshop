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
    $userview->render();
}