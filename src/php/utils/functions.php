<?php

function getPageContent($name) {
    switch ((isset($_GET[$name]) ? $_GET[$name] : '')) {
        case 'rods':
            echo "<p> rods </p>";
            break;
        default:
            echo "<p> default </p>";
            break;
    }
}

function displayNav($pages) {
    echo "<nav><ul>";
    foreach ($pages as $page) {
        echo "<li class=\"$page[0]\"><a href=\"index.php?page=$page[1]\" alt=\"$page[1]\">$page[2]</a></li>";
    }
    echo "</nav></ul>";
}