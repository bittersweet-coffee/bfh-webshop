<?php

if (isset($_GET["action"]) && strip_tags($_GET["action"] == "add")) {
    $product = strip_tags($_GET["product"]);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = new ShoppingCart();
    }
    $cart = $_SESSION["cart"];
    $cart->addItem($product, 1);
    echo $cart->getNbrItems();
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
        foreach ($this->cartItems as $item) {
            $nbr += $item;
        }
        return $nbr;
    }


}