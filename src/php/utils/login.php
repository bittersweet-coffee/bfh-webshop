<?php

if (isset($_POST["Login"])) {
    if (checkUserExistence() && checkPassword()) {
        echo "<h3> Loggin Successfully </h3>";
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
