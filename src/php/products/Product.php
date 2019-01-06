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

    private CONST getProductTypes = "SELECT p_type.name FROM p_type";

    private CONST getProductID = "SELECT id FROM p_type WHERE  name LIKE ?";

    private CONST getLastID_PR = "SELECT MAX(id) FROM `p_real`";
    private CONST getLastID_P = "SELECT MAX(id) FROM `product`";


    private CONST insertPReal = "INSERT INTO p_real (`id`, `l_id`, `name`, `description`) 
        VALUES (?,?,?,?)";

    private CONST insertP = "INSERT INTO `product`(`id`, `name`, `price`, `p_id`, `d_id`) 
        VALUES (?,?,?,?,?)";

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

    private static function render_select_AddProductTypes() {
        $ptype = self::getProductTypes();
        $html = "<h4>" . translate("Select a product type") . "</h4>";
        $html = $html . "<label>" . translate("Product Type") .  ":</label>";
        $html = $html . "<select id='addProduct' name='addP' required>";
        $html = $html . "<option value=''></option>";
        while($row = mysqli_fetch_row($ptype)) {
            $html = $html . "<option value='$row[0]'>" . translate($row[0]) . "</option>";
        }
        $html = $html . "</select>";
        return $html;
    }

    public static function render_addProductForms() {
        return ["<div id='addProductInput'>",
            self::render_select_AddProductTypes(),
            self::render_inputTagsEN(),
            self::render_inputTagsDE(),
            self::render_Price(),
            "</div>"];
    }

    private static function render_inputTagsEN() {
        $html = "<div>";
        $html = $html. "<h4>" . translate("Product English"). "</h4>";
        $lang = "EN";
        $html = $html. self::setInputTag("text", "Productname", $lang);
        $html = $html . "<p>" . translate("Description"). "</p>";
        $html = $html ."<textarea id='DescriptionEN' rows='4' cols='50' name='DescriptionEN'></textarea><br/>";
        return $html . "</div>";
    }

    private static function render_inputTagsDE() {
        $html = "<div>";
        $html = $html. "<h4>" . translate("Product German"). "</h4>";
        $lang = "DE";
        $html = $html. self::setInputTag("text", "Productname", $lang);
        $html = $html . "<p>" . translate("Description"). "</p>";
        $html = $html ."<textarea id='DescriptionDE' rows='4' cols='50' name='DescriptionDE'></textarea><br/>";
        return $html . "</div>";
    }

    private static function render_Price() {
        return "<h4>" . translate("Set the Product Price") . "</h4>"
            . self::setInputTag("text", "Price");
    }

    private static function setInputTag($type, $name, $lang = ""): string {
        $t_name = translate($name);
        $t_mark = translate("can't be empty or is not valid");
        $id = $name . $lang;
        $inputTag = "
            <p id='$id'>
                <label>$t_name: </label>
                <input type='$type' name='$id' required>
                <mark>'$t_name' $t_mark</mark>
            </p>
            ";
        return $inputTag;
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

    public static function getProductTypes() {
        $query = Database::doQueryPrepare(self::getProductTypes);
        $query->execute();
        $result = $query->get_result();
        if (!$result) {
            return false;
        }
        return $result;
    }

    public static function storeProduct($type, $pEN, $pDE, $price, $dEN="", $dDE="") {
        $typeID = self::getTypeID($type);
        $lastRealProductID = self::getLastID(self::getLastID_PR);
        $resPR_EN = self::StoreRealProduct($lastRealProductID + 1, 1, $pEN, $dEN);
        $resPR_DE = self::StoreRealProduct($lastRealProductID + 2, 2, $pDE, $dDE);
        $lastProductID = self::getLastID(self::getLastID_P);
        $resP_EN = self::storeProd($lastProductID + 1, $pEN, $price, $typeID, $lastRealProductID + 1);
        $resP_DE = self::storeProd($lastProductID + 2, $pEN, $price, $typeID, $lastRealProductID + 2);
        return $resPR_EN && $resPR_DE && $resP_EN && $resP_DE;
    }

    private static function getTypeID($type) {
        $query = Database::doQueryPrepare(self::getProductID);
        $query->bind_param('s', $type);
        $query->execute();
        $result = $query->get_result();
        if (!$result || $result->num_rows !== 1) {
            return false;
        }
        $row = $result->fetch_assoc();
        return $row['id'];
    }

    private static function getLastID($query) {
        $query = Database::doQueryPrepare($query);
        $query->execute();
        $res = $query->get_result();
        $row = mysqli_fetch_row($res);
        return $row[0];
    }

    private static function StoreRealProduct($ID, $ID_L, $NAME, $DESC) {
        $query = Database::doQueryPrepare(self::insertPReal);
        $query->bind_param('iiss', $ID, $ID_L, $NAME, $DESC);
        $query->execute();
        $result = $query->get_result();
        return $result;
    }

    private static function storeProd($ID, $NAME, $PR, $ID_T, $ID_P) {
        $query = Database::doQueryPrepare(self::insertP);
        $query->bind_param('isiii', $ID, $NAME, $PR, $ID_T, $ID_P);
        $query->execute();
        $result = $query->get_result();
        return $result;
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