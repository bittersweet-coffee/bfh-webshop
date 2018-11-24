<?php
if(isset($_POST['confirm'])){
    $to = "jan.henzi@hotmail.com";
    $from = "aanda.shop";
    $first_name = "Jan";
    $last_name = "Henzi";
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