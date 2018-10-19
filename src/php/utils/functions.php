<?php

function getPageName($name, $default) {
    if (!isset($name)) {
        return $default;
    }
    return $name;
}