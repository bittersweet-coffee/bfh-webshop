<?php
if(isset($_POST['confirm'])){
    if (!get_param('cart', false)) {
        $content = getProduct();
    } else {
        $content = $_SESSION["cart"];
    }
    $customer = $_SESSION['customer'];

    $to = $customer->getEmail();
    $from = "aanda.shop";
    $subject = translate("Confirmation");
    $productInfos = $content->render();
    $purchaseHeader = "---" . translate("Purchase Information"). "---\n";
    $customerInformationHeader = "---" . translate("Customer Information"). "...\n";
    $cInfo = $customer->renderMail();
    $text = "Your order will be processed within the next few days. Best regards, a&a-Team";
    $message = "
        $purchaseHeader
        $productInfos
        $customerInformationHeader
        $cInfo
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