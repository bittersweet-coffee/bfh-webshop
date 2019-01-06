<?php

class Form {
    private $html;
    private $method = "POST";
    private $url;
    private $lang;

    public function __construct(string $language,string $page="") {
        $this->lang=$language;
        if ($page == "") {
            $this->url = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $language);
        } else {
            $this->url = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $language);
            $this->url = add_param(htmlspecialchars($this->url), "page", $page);
        }
    }

    public function appendContext($context) {
        $this->html = $this->html . $context;
    }

    public function render() {
        return $this->html = $this->html ."</form>";
    }

    public function setHtml($html): void {
        $this->html = $html;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getCancleButton($reason) {
        $button = "<input
                type='submit'
                value='".translate("Cancle")."' 
                formnovalidate='true'
                onclick='return cancleForm(this)' />" ;
        return $button;
    }

    public function setInputTag($type, $name) {
        $t_name = translate($name);
        $t_mark = translate("can't be empty or is not valid");
        $inputTag = "
            <p id='$name'>
                <label>$t_name: </label>
                <input type='$type' name='$name' required>
                <mark>'$t_name' $t_mark</mark>
            </p>
            ";
        return $inputTag;
    }
}

class BuyForm extends Form {

    private $headerText = "Product Information";
    private $product;

    public function __construct(string $language, string $page = "") {
        $this->product = getProduct();
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        $url = add_param($url,"product", $this->product->getRealName());
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        $header = "<h2>" . translate($this->headerText) . "</h2>";
        $labelText = translate("How many would you like?");
        $label = "<label>" . $labelText . "</label>";
        $ptext = translate("Donation of 5.- to \"Save a Fisherman\"");
        $p = "<p>" . $ptext . "</p>";
        $inputTextYes = translate("Yes, good thing!");
        $inputTextNo = translate("No Thanks.");
        $submitText = translate("Buy");
        $input1 = "<input id='amount' name='amount' type='number' value='1' min='1''>";
        $input2 = "<input type='radio' name='donation' value=5> " . $inputTextYes;
        $input3 = "<input type='radio' name='donation' value=0 checked='checked'> " . $inputTextNo;
        $submit = "<input type='submit' name='buy' value='".$submitText."'/>";

        $content = "<p>". $label
                        . $input1
                        . "<p id='amountAlert'></p>"
                        . $p
                        . $input2
                        . $input3 . "<br/>"
                        . $submit;

        parent::appendContext($content);
        $content = $header . $this->product->render() . parent::render();
        return $content;
    }


}

class ShippingForm extends Form {

    private $headerText = "Shipping";
    private $purchaseHeaderText = "Purchase Information";
    private $customerInfoHeaderText = "Customer Information";
    private $product;


    public function __construct(string $language, string $page = "") {
        $this->product = getProduct();
        $this->product->setAmount(get_param("amount", 1));
        $this->product->setDonation(get_param("donation", 0));
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        $url = add_param($url,"product", $this->product->getRealName());
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        $header = "<h2>" . translate($this->headerText) . "</h2>";
        $purchaseHeader = "<h3>". translate($this->purchaseHeaderText) . "</h3>";
        $customerInformationHeader = "<h3>". translate($this->customerInfoHeaderText) . "</h3>";
        $commentText = translate("Leave Some Comments here");
        $comment ="<p>" . $commentText . "</p>";
        $comment = $comment ."<textarea id='comment' rows='4' cols='50' name='comment'></textarea><br/>";
        $submitText = translate("Ship");
        $submit = "<input type='submit' name='shipping' value='".$submitText."'/>";

        parent::appendContext($header);
        parent::appendContext($purchaseHeader);
        parent::appendContext($this->product->render());
        parent::appendContext($customerInformationHeader);
        parent::appendContext(Customer::render_InputTags());
        if (getLanguage(["en", "de"]) == "de") {
            parent::appendContext(file_get_contents('html/PaymentMethod_de.html'));
        } else {
            parent::appendContext(file_get_contents('html/PaymentMethod_en.html'));
        }
        parent::appendContext($comment);
        parent::appendContext($submit);

        $context = parent::render();
        return $context;
    }

}

class ConfirmationForm extends Form {

    private $customer;
    private $product;
    private $productPayment;

    public function __construct(string $language, string $page = "") {
        $this->product = getProduct();
        $this->customer = $_SESSION['customer'];
        $this->productPayment = $_SESSION['payment'];
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        $purchaseHeader = "<h3>" . translate("Purchase Information"). "</h3>";
        $customerInformationHeader = "<h3>" . translate("Customer Information"). "</h3>";
        $paymentInformationHeader = "<h3>" . translate("Payment Information"). "</h3>";
        parent::appendContext($purchaseHeader);
        parent::appendContext($this->product->render());
        parent::appendContext($customerInformationHeader);
        parent::appendContext($this->customer->render());
        parent::appendContext($paymentInformationHeader);
        parent::appendContext($this->productPayment->render());
        if (isset($_SESSION['comment']) && $_SESSION['comment'] != "") {
            $comment = "<h5>"  . translate("Your Comment") . "</h5>";
            $comment = $comment . "<p>" . $_SESSION['comment'] . "</p>";
            parent::appendContext($comment);
        }
        $submitText = translate("Confirm");
        $submit = "<input type='submit' name='confirm' value='".$submitText."' onclick='return confirmForm(this)'/>";
        parent::appendContext($submit);
        parent::appendContext(parent::getCancleButton("Purchase"));
        return parent::render();
    }
}

class RegisterForm extends Form {

    public function __construct(string $language, string $page = "")
    {
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        $signInHeader ="<h2> ". translate("Registration") . " </h2>";
        parent::appendContext($signInHeader);
        parent::appendContext(User::render_InputTags());
        parent::appendContext(Customer::render_InputTags());
        $submitText = translate("Register");
        $submit = "<input type='submit' name='register' value='".$submitText."'/>";
        parent::appendContext($submit);
        parent::appendContext(parent::getCancleButton("Registration"));
        return parent::render();
    }
}

class LoginForm extends Form {
    private $userInputTag ="";
    private $signInHeader="<h2> Login </h2>";

    public function __construct(string $language, string $page = "") {
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        $this->setUserInputTag("text", "Username");
        $this->setUserInputTag("password", "Password");
        parent::setHtml("<form method='$method' action='$url'>");
    }

    private function setUserInputTag($type, $name) {
        $this->userInputTag = $this->userInputTag . parent::setInputTag($type,$name);
    }

    public function render() {
        parent::appendContext($this->signInHeader);
        parent::appendContext($this->userInputTag);
        $submit = "<input type='submit' value='Login' name='Login'/>";
        parent::appendContext($submit);
        parent::appendContext(parent::getCancleButton("Login"));
        return parent::render();
    }
}

class UserareaUserForm extends Form {

    public function __construct(string $language, string $page = "")
    {
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        foreach ($this->getFormsElements() as $formsElement) {
            parent::appendContext($formsElement);
        }
        return parent::render();
    }

    private function getUsernameField(string $name) {
        $t_name = translate("Username");
        return "
            <label>$t_name: $name</label>
        ";
    }

    private function getFormsElements() {
        $header = "<h3>" . translate("Change user data") . "</h3>";
        $username = $_SESSION['user']['username'];
        $usernameField = $this->getUsernameField($username);
        $old_passwordField = parent::setInputTag("password", "Oldpassword");
        $new_passwordField = parent::setInputTag("password", "Newpassword");
        $retype = parent::setInputTag("password", "Retype");
        $submit = "<input type='submit' value='". translate("Change Password") ."' name='post_changeUserData'/>";
        return [$header,
            $usernameField,
            $old_passwordField,
            $new_passwordField,
            $retype,
            $submit,
            parent::getCancleButton("noChange")];
    }
}

class UserareaCustomerForms extends Form {

    private $username;

    public function __construct(string $language, string $page = "") {
        $this->username = $_SESSION['user']['username'];
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        foreach ($this->getFormsElements() as $formsElement) {
            parent::appendContext($formsElement);
        }
        return parent::render();
    }

    private function getFormsElements() {
        $header = "<h3>" . translate("Change customer data") . "</h3>";
        $usernameField = $this->getUsernameField($this->username);
        $inputTags = Customer::render_InputTags();
        $submit = "<input type='submit' value='". translate("Change user data") ."' name='post_changeCustomerData'/>";
        return [$header,
            $usernameField,
            $inputTags,
            $submit,
            parent::getCancleButton("noChange")];
    }

    private function getUsernameField(string $name) {
        $t_name = translate("Username");
        return "
            <label>$t_name: $name</label>
        ";
    }
}

class AddProductForms extends Form {

    public function __construct(string $language, string $page = "") {
        if (!checkAdmin()) {
            createErrorUrl("NotAdminUser");
        }
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        foreach ($this->getFormsElements() as $formsElement) {
            parent::appendContext($formsElement);
        }
        return parent::render();
    }

    private function getFormsElements() {
        $header = "<h3>" . translate("Add a new Product") . "</h3>";
        $html = "";
        foreach (Product::render_addProductForms() as $element) {
            $html = $html . $element;
        }
        $submit = "<input type='submit' value='". translate("Add a new Product") ."' name='post_addProduct'/>";
        return [$header,
            $html,
            $submit,
            parent::getCancleButton("noAdd")];
    }

}