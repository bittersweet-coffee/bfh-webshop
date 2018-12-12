<?php

class Form {
    private $html;
    private $method = "POST";
    private $url;
    private $lang;

    public function __construct(string $language,string $page="") {
        $this->lang=$language;
        if ($page == "") {
            $this->url = $_SERVER['PHP_SELF'] . "?lang=$language";
        } else {
            $this->url = $_SERVER['PHP_SELF'] . "?lang=$language" . "&page=$page";
        }
    }

    public function appendContext($context) {
        $this->html = $this->html . $context;
    }

    public function render() {
        return $this->html = $this->html ."</form>";
    }

    public function setHtml($html): void
    {
        $this->html = $html;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getCancleButton($reason) {
        $url = $_SERVER['PHP_SELF'] . "?lang=$this->lang";
        $button = "<input
                type='submit'
                value='Cancle' 
                formnovalidate='true'
                onclick='return cancleForm(this)' />" ;
        return $button;
    }

    public function setInputTag($type, $name) {
        $cookie = $this->checkCookie($name);
        $inputTag = "
            <p id='$name'>
                <label>$name: </label>
                <input type='$type' name='$name' value='$cookie' required>
                <mark>'$name' can't be empty or is not valid.</mark>
            </p>
            ";
        return $inputTag;
    }

    private function checkCookie($id) {
        if (isset($_COOKIE[$id])) {
            return $_COOKIE[$id];
        }
        return '';
    }
}

class BuyForm extends Form {

    private $header = "<h2>Product Information</h2>";

    public function __construct(string $language, string $page = "") {
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        parent::setHtml("<form method='$method' action='$url'>");

    }

    public function render() {
        $product = $_SESSION['product'];
        parent::appendContext("
             <p>
                <label>How many would you like?</label>
                <input id='amount' name='number' type='number' value='1' onchange='checkAmount()'>
                <p id='amountAlert'></p>
             </p>
             <p> Donation of 5.- to \"Safe A Fisherman\":</p>
             <input type='radio' name='donation' value=5> Yes, good thing!
             <input type='radio' name='donation' value=0 checked='checked'> No Thanks. <br>
             <input type='submit' value='Ship' name='Ship'/>
            ");
        $content = $this->header . $product->render() . parent::render();
        return $content;
    }


}

class ShippingForm extends Form {

    private $header = "<h2>Shipping</h2>";
    private $purchaseHeader = "<h3>Purchase Information</h3>";
    private $customerInformationHeader = "<h3>Customer Information </h3>";
    private $customerInputTag ="";
    private $product;


    public function __construct(string $language, string $page = "") {
        $this->product = $_SESSION['product'];
        $this->product->setAmount($_SESSION['amount']);
        $this->product->setDonation($_SESSION['donation']);
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        parent::appendContext($this->purchaseHeader);
        parent::appendContext($this->product->render());
        parent::appendContext($this->customerInformationHeader);
        parent::appendContext($this->customerInputTag);
        $comment ="<p>Leave Some Comments here:</p>";
        $comment = $comment ."<textarea id='comment' rows='4' cols='50' name='comment'></textarea>";
        $submit = "<input type='submit' value='Submit' name='submit'/>";
        parent::appendContext(file_get_contents('html/PaymentMethod.html'));
        parent::appendContext($comment);
        parent::appendContext($submit);
        $context = $this->header . parent::render();
        return $context;
    }

    public function setCustomerInputTag($type, $name) {
        $this->customerInputTag = $this->customerInputTag . parent::setInputTag($type,$name);
    }

}

class ConfirmationForm extends Form {

    private $customer;
    private $product;
    private $productPayment;
    private $purchaseHeader = "<h3>Purchase Information</h3>";
    private $customerInformationHeader = "<h3>Customer Information </h3>";
    private $paymentInformationHeader = "<h3>Payment Information </h3>";

    public function __construct(string $language, string $page = "") {
        $this->product = $_SESSION['product'];
        $this->customer = new Customer(
            $_SESSION['Firstname'],
            $_SESSION['Lastname'],
            $_SESSION['Email'],
            $_SESSION['PostalCode'],
            $_SESSION['Address'],
            $_SESSION['Country']
        );
        $_SESSION['customer'] = $this->customer;
        if ($_SESSION['payment'] == "card") {
            $this->productPayment = ProductPayment::cardPayment(
                $_SESSION['payment'],
                $_SESSION['card_name'],
                $_SESSION['card_number'],
                $_SESSION['card_cvv']);
        } else if ($_SESSION['payment'] == "paper") {
            $this->productPayment = ProductPayment::billPayment(
                $_SESSION['payment'],
                $_SESSION['bill_firstname'],
                $_SESSION['bill_lastname'],
                $_SESSION['bill_address'],
                $_SESSION['bill_postalCode'],
                $_SESSION['bill_country']
            );
        }


        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        parent::setHtml("<form method='$method' action='$url'>");

    }

    public function render() {
        parent::appendContext($this->purchaseHeader);
        parent::appendContext($this->product->render());
        parent::appendContext($this->customerInformationHeader);
        parent::appendContext($this->customer->render());
        parent::appendContext($this->paymentInformationHeader);
        parent::appendContext($this->productPayment->render());
        if (isset($_SESSION['comment']) && $_SESSION['comment'] != "") {
            $comment = "<h5> Your Comment</h5>";
            $comment = $comment . "<p>" . $_SESSION['comment'] . "</p>";
            parent::appendContext($comment);
        }
        $submit = "<input type='submit' value='Confirm' name='confirm' onclick='return confirmForm(this)'/>";
        $url = parent::getUrl();
        parent::appendContext($submit);
        parent::appendContext(parent::getCancleButton("Purchase"));
        return parent::render();
    }
}

class RegisterForm extends Form {

    private $userInputTag ="";
    private $signInHeader="<h2> Registration </h2>";

    public function __construct(string $language, string $page = "")
    {
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function setUserInputTag($type, $name) {
        $this->userInputTag = $this->userInputTag . parent::setInputTag($type,$name);
    }

    public function render() {
        parent::appendContext($this->signInHeader);
        parent::appendContext($this->userInputTag);
        $submit = "<input type='submit' value='Register' name='register'/>";
        parent::appendContext($submit);
        parent::appendContext(parent::getCancleButton("Registration"));
        return parent::render();
    }
}