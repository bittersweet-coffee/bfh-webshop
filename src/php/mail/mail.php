<?php
if(isset($_POST['confirm'])){
    $to = "jan.henzi@hotmail.com";
    $from = "aanda.shop.info.ch";
    $first_name = "Jan";
    $last_name = "Henzi";
    $subject = "Test";
    $message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . "Gugus2";
    $headers = "From:" . $from;
    mail($to,$subject,$message,$headers);
    // You can also use header('Location: thank_you.php'); to redirect to another page.
}