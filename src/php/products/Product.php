<?php

class Product
{
    private $name;
    private $realName;
    private $price;
    private $description;
    private $amount;
    private $donation;
    private $totoal = 0;

    private CONST productQuery = "SELECT product.name, p_real.name, product.price, p_real.description 
        FROM product
        JOIN p_real ON product.d_id=p_real.id
        JOIN language on p_real.l_id=language.id
        JOIN p_type on product.p_id=p_type.id
        WHERE language.short LIKE ? and p_type.name LIKE ?";

    private CONST singleProductQuery = "SELECT product.name as realName, 
            p_real.name as name, 
            product.price as price, 
            p_real.description as descr 
        FROM product
        JOIN p_real ON product.d_id=p_real.id
        JOIN language on p_real.l_id=language.id
        JOIN p_type on product.p_id=p_type.id
        WHERE language.short LIKE ? and product.name LIKE ?";

    public function __construct($realName, $name, $price, $description)
    {
        $this->realName = $realName;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    public function render() {
        $labelNameText = translate("Name");
        $labelPriceText = translate("Price");
        $labelDescriptionText = translate("Description");
        $labelName = "<label>" . $labelNameText . ": </label>";
        $labelPrice = "<label>" . $labelPriceText . ": </label>";
        $labelDescription = "<label>" . $labelDescriptionText . ": </label>";
        $html =
            "
                <p>$labelName $this->name;</p>
                <p>$labelPrice $this->price</p>
                <p>$labelDescription $this->description</p>
            ";

        if (isset($this->amount)) {
            $labelAmountText = translate("Amount");
            $labelDonationText = translate("Donation");
            $html = $html . "<p><label>". $labelAmountText . ": </label>$this->amount</p>";
        }
        if (isset($this->donation) && $this->donation != 0) {
            $html = $html . "<p><label>" . $labelDonationText . ": </label>$this->donation</p>";
            $fishermanText = translate("Thanks for the donation to \"Safe A Fisherman\"");
            $html = $html . "<p>". $fishermanText . "</p>";
        }
        $this->totoal = $this->getTotoal();
        if ($this->totoal > 0) {
            $totalPriceText = translate("Total Price");
            $html = $html . "<p><label>" . $totalPriceText .": </label>$this->totoal</p>";
        }
        return $html;
    }

    public function renderMailContent() {
        $context = "
        ";
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRealName()
    {
        return $this->realName;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    public function setDonation($donation): void
    {
        $this->donation = $donation;
    }

    public function getTotoal()
    {

        if (isset($this->amount)) {
            $this->totoal = $this->price * $this->amount;
        }
        if (isset($this->donation)) {
            $this->totoal = $this->totoal + $this->donation;
        }
        return $this->totoal;
    }

    public static function getProductsFromDatabase($type, $language) {
        $query = Database::doQueryPrepare(self::productQuery);
        $query->bind_param('ss', $language, $type);
        $query->execute();
        $result = $query->get_result();
        return $result;
    }

    public static function getSingleProduct($lang, $name){
        $query = Database::doQueryPrepare(self::singleProductQuery);
        $query->bind_param('ss', $lang, $name);
        $query->execute();
        $result = $query->get_result();
        if (!$result || $result->num_rows !== 1) {
            return false;
        }
        $row = $result->fetch_assoc();
        return $row;
    }


}

class ProductHandler {
    private $products;

    public function __construct() {
        $this->products = array();
    }

    public function setupProducts($type, $language) {
        $products = Product::getProductsFromDatabase($type,$language);
        while($row = mysqli_fetch_row($products)) {
            $product = new Product($row[0], $row[1], $row[2], $row[3]);
            $this->addProduct($product);
        }
    }

    public function renderAllProducts() {
        $lang = getLanguage(["en", "de"]);
        $page = "buy";
        $html = "<div id='container'>";
        foreach ($this->products as $product) {
            $name = $product->getRealName();
            $url = htmlspecialchars($_SERVER['PHP_SELF']) . "?lang=$lang" . "&page=$page";
            $url = $url . "&product=$name";
            $html = $html . "<div id='box'>";
            $html = $html . $product->render();
            $html = $html . "<a href='$url' class='button'>" . translate("Buy Now") . "</a></div>";
        }
        echo $html. "</div>";
    }

    private function addProduct(Product $product ) {
        $this->products[] = $product;
        $this->storeInSession($product->getName(),$product);
    }

    private function storeInSession(string $key, Product $value) {
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = $value;
        }
    }
}

class ProductPayment {

    private $paymentMethod;
    private $card_name;
    private $card_number;
    private $card_cvv;
    private $bill_firstname;
    private $bill_lastname;
    private $bill_address;
    private $bill_postalCode;
    private $bill_country;

    public function __construct(string $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public static function cardPayment(string $paymentMethod,
                                       $card_name,
                                       string $card_number,
                                       int $card_cvv) {
        $instance = new self($paymentMethod);
        $instance->loadCardPayment($card_name, $card_number, $card_cvv);
        return $instance;
    }

    public static function billPayment(string $paymentMethod,
                                       string $bill_firstname,
                                       string $bill_lastname,
                                       string $bill_address,
                                       string $bill_postalCode,
                                       string $bill_country) {
        $instance = new self($paymentMethod);
        $instance->loadBillPayment($bill_firstname,
            $bill_lastname,
            $bill_address,
            $bill_postalCode,
            $bill_country);
        return $instance;
    }

    protected function loadCardPayment(string $card_name, string $card_number, string $card_cvv) {
        $this->card_name = $card_name;
        $this->card_number = $card_number;
        $this->card_cvv = $card_cvv;
    }

    protected function loadBillPayment(string $bill_firstname,
                                       string $bill_lastname,
                                       string $bill_address,
                                       string $bill_postalCode,
                                       string $bill_country) {
        $this->bill_firstname = $bill_firstname;
        $this->bill_lastname = $bill_lastname;
        $this->bill_address = $bill_address;
        $this->bill_postalCode = $bill_postalCode;
        $this->bill_country = $bill_country;
    }

    public function render() {
            if ($this->paymentMethod == "card") {
                return $this->renderCard();
            } else if ($this->paymentMethod == "paper") {
                return $this->renderBill();
            } else {
                return "<h5> Something went wrong! Please contact Shop-Admin! </h5>";
            }
    }

    public function renderCard() {
        $context = "
            <h4> " . translate("Credit Card Information") ." </h4>
            <p><label>" . translate("Name on the Card"). " : </label> $this->card_name</p>
            <p><label>". translate("Cardnumber")." : </label> $this->card_number</p>
            <p><label>CVV: </label> $this->card_cvv</p>
            ";
        return $context;
    }

    public function renderBill() {
        $context = "
            <h4> ". translate("Billing Address") ." </h4>
            <p><label>". translate("Firstname") .": </label> $this->bill_firstname</p>
            <p><label>". translate("Lastname") .": </label> $this->bill_lastname</p>
            <p><label>". translate("Address") .": </label> $this->bill_address</p>
            <p><label>". translate("PostalCode") .": </label> $this->bill_postalCode</p>
            <p><label>". translate("Country") .": </label> $this->bill_country</p>
        ";
        return $context;
    }



}