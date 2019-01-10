<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// from: http://php.net/manual/de/language.oop5.autoload.php
function __autoload($class_name) {
    // directories
    $directorys = array(
        'php/user/userarea/controller/',
        'php/user/userarea/model/',
        'php/user/userarea/view/',
        'php/products/',
        'php/utils/',
        'php/customer'

    );

    foreach($directorys as $directory) {
        if(file_exists($directory.$class_name . '.php')) {
            require_once($directory.$class_name . '.php');
                return;
        }
    }
}
