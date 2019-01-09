<?php
if(isset($_POST['confirm'])){
    if (!get_param('cart', false)) {
        $content = getProduct();
    } else {
        $content = $_SESSION["cart"];
    }
    $paymentmethod = $_SESSION['payment'];
    $customer = $_SESSION['customer'];

    $to = $customer->getEmail();
    $from = "aanda.shop";
    $first_name = $customer->getFirstname();
    $last_name = $customer->getLastname();
    $subject = translate("Confirmation");
    $productInfos = $content->render();
    $purchaseHeader = "<h3>" . translate("Purchase Information"). "</h3>";
    $customerInformationHeader = "<h3>" . translate("Customer Information"). "</h3>";
    $cInfo = $customer->render();
    $paymentInformationHeader = "<h3>" . translate("Payment Information"). "</h3>";
    $pInfo = $paymentmethod->render();
    $text = "Your order will be processed within the next few days. Best regards, a&a-Team";
    $message = "
        $purchaseHeader
        $productInfos
        $customerInformationHeader
        $cInfo
        $paymentInformationHeader
        $pInfo
        $text
    ";
    $headers = "From:" . $from;
    mail($to,$subject,$message,$headers);

    /*
     * Funktioniert auch. Der Server müsste dafür aber weiteren hardenings unterzogen werden.
     *
     */
    //$subject2 = "COPY: confirmation";
    //mail($from,$subject2,$message,$headers);
}