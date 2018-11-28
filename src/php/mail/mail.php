<?php
if(isset($_POST['confirm'])){
    $product = $_SESSION['product'];
    $paymentmethod = $_SESSION['payment'];
    $customer = $_SESSION['customer'];

    $to = $customer->getEmail();
    $from = "aanda.shop";
    $first_name = $customer->getFirstname();
    $last_name = $customer->getLastname();
    $subject = "confirmation";

    $message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . "Gugus2";
    $headers = "From:" . $from;
    mail($to,$subject,$message,$headers);

    /*
     * Funktioniert auch. Der Server muss aber dafür weiteren hardenings unterzogen werden.
     * Wir senden Mails ohne authentication.
     */
    //$subject2 = "COPY: confirmation";
    //mail($from,$subject2,$message,$headers);
}