<?php

if (isset($_GET["actionCart"])) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $cart = $_SESSION["cart"];
    if (strip_tags($_GET["action"] == "add")) {
        $product = strip_tags($_GET["product"]);
        $cart->addItem($product, 1);
        echo $cart->getNbrItems();
    }
    if (strip_tags($_GET["action"] == "remove")) {
        $product = strip_tags($_GET["product"]);
        $cart->removeItem($product, 1);
        $amount_total = $cart->getNbrItems();
        $amount_item = $cart->getAmount($product);
        echo "$amount_total,$amount_item";
    }
    if (strip_tags($_GET["action"] == "addMore")) {
        $product = strip_tags($_GET["product"]);
        $cart->addItem($product, 1);
        $amount_total = $cart->getNbrItems();
        $amount_item = $cart->getAmount($product);
        echo "$amount_total,$amount_item";
    }
}

class ShoppingCart {

    private $cartItems = [];

    public function addItem($item, $num) {
        if (!isset($this->cartItems[$item])) {
            $this->cartItems[$item] = 0;
        }
        $this->cartItems[$item] += $num;
    }

    public function removeItem($item, $num) {
        if (!isset($this->cartItems[$item])) {
            return;
        }
        $this->cartItems[$item] -= $num;
        if ($this->cartItems[$item] <= 0) {
            unset($this->cartItems[$item]);
        }
    }

    public function getItems() {
        return $this->cartItems;
    }
    public function isEmpty() {
        return count($this->cartItems) == 0;
    }

    public function getNbrItems() : int{
        $nbr = 0;
        foreach ($this->cartItems as $key=>$value) {
            $nbr += $value;
        }
        return $nbr;
    }

    public function getAmount($item) : int {
        if (array_key_exists($item, $this->cartItems)) {
            return $this->cartItems[$item];
        } else {
            return 0;
        }

    }

    public function render_form() {
        $headerText = translate("Shoppingcart");
        if ($this->isEmpty()) {
            $html = "<h2> $headerText </h2>";
            $html = $html ."<p>" . translate("Your Shoppingcart is Empty") . "</p>";
            return "<div class='cart_empty'>$html</div>";
        }
        $html = "<div class='cartForm'>";
        $form = new ShoppingcartForm(getLanguage(["en", "de"]), $_SESSION["cart"], "shipping");
        $html = $html .$form->render();
        $html = $html . "</div>";
        return $html;
    }

    public function render() {
        $html = "<table>";
        $t_Article = translate("Article");
        $t_Amount = translate("Amount");
        $t_Price = translate("Price");
        $t_Total = translate("Total");
        $tableHeader = "<tr><th>$t_Article</th><th>$t_Amount</th><th>$t_Price</th>
                            <th>$t_Total</th></tr>";
        $html = $html . $tableHeader;
        $total = 0;
        $cart = $_SESSION["cart"];
        foreach ($cart->getItems() as $item => $num) {
            $row_total = 0;
            $product = Product::getSingleProduct(getLanguage(["en", "de"]), $item);
            $name = $product['name'];
            $price = $product['price'];
            $row_total += $price * $num;
            $total += $row_total;
            $td_name = "<td name='$name'>$name</td>";
            $td_amou = "<td name='amount' id='amount'>$num</td>";
            $td_pric = "<td name='price'>$price</td>";
            $td_tota = "<td name='row_total' id='rowtotal'>$row_total</td>";
            $tableRow = "<tr id='$name'>$td_name $td_amou $td_pric $td_tota</tr>";
            $html = $html . $tableRow;
        }
        $html = $html . "<tr><td rowspan='3'></td><td name='total' id='supertotal'>$total</td></tr>";
        $html = $html . "</table>";

        return $html;
    }

    public function renderMail() {
        $t_Article = translate("Article");
        $t_Amount = translate("Amount");
        $t_Price = translate("Price");
        $t_Total = translate("Total");
        $header = "---$t_Article---$t_Amount---$t_Price---$t_Total---\n\n";
        $mail = $header;
        $total = 0;
        $cart = $_SESSION["cart"];
        foreach ($cart->getItems() as $item => $num) {
            $row_total = 0;
            $product = Product::getSingleProduct(getLanguage(["en", "de"]), $item);
            $name = $product['name'];
            $price = $product['price'];
            $row_total += $price * $num;
            $total += $row_total;
            $td_name = "---$name";
            $td_amou = "---$num";
            $td_pric = "---$price";
            $td_tota = "---$row_total---\n";
            $row = "$td_name $td_amou $td_pric $td_tota";
            $mail = $mail . $row;
            $mail = $mail . "-----------------------------------------------\n";
        }
        $mail = $mail . "\n\nTotal: $total";

        return $mail;
    }

    public function cleanUp() {
        foreach ($this->cartItems as $key=>$value) {
            $this->cartItems[$key] = 0;
        }
    }

}