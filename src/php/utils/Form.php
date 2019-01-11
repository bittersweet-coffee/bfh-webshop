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
    private $cart;


    public function __construct(string $language, string $page = "") {
        $this->cart = get_param('cart', false);
        if (!$this->cart) {
            $this->product = getProduct();
            $this->product->setAmount(get_param("amount", 1));
            $this->product->setDonation(get_param("donation", 0));
        }
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        if (!$this->cart) {
            $url = add_param($url,"product", $this->product->getRealName());
        } else {
            $url = add_param($url,"cart", true);
        }
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        $header = "<h2>" . translate($this->headerText) . "</h2>";
        $purchaseHeader = "<h3>". translate($this->purchaseHeaderText) . "</h3>";
        $customerInformationHeader = "<h3>". translate($this->customerInfoHeaderText) . "</h3>";
        $commentText = translate("Leave Some Comments here");
        $comment ="<p>" . $commentText . "</p>";
        $comment = $comment ."<textarea id='comment' rows='4' cols='50' name='comment'></textarea><br/>";
        $submitText = translate("Continue to confirm or cancel");
        $submit = "<input type='submit' name='shipping' value='".$submitText."'/>";

        parent::appendContext($header);
        parent::appendContext($purchaseHeader);
        if (!$this->cart) {
            parent::appendContext($this->product->render());
        } else {
            $cart = $_SESSION["cart"];
            parent::appendContext($cart->render());
        }
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
    private $cart;

    public function __construct(string $language, string $page = "") {
        $this->cart = get_param('cart', false);
        if (!$this->cart) {
            $this->product = getProduct();
        }
        $this->customer = $_SESSION['customer'];
        $this->productPayment = $_SESSION['payment'];
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        if (!$this->cart) {
            $url = add_param($url,"product", $this->product->getRealName());
        } else {
            $url = add_param($url,"cart", true);
        }
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        $purchaseHeader = "<h3>" . translate("Purchase Information"). "</h3>";
        $customerInformationHeader = "<h3>" . translate("Customer Information"). "</h3>";
        $paymentInformationHeader = "<h3>" . translate("Payment Information"). "</h3>";
        parent::appendContext($purchaseHeader);
        if (!$this->cart) {
            parent::appendContext($this->product->render());
        } else {
            $cart = $_SESSION["cart"];
            parent::appendContext($cart->render());
        }
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

class UserareaCustomerForm extends Form {

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

class AddProductForm extends Form {

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
        foreach (Product::render_addProductForm() as $element) {
            $html = $html . $element;
        }
        $submit = "<input type='submit' value='". translate("Add a new Product") ."' name='post_addProduct'/>";
        return [$header,
            $html,
            $submit,
            parent::getCancleButton("noAdd")];
    }

}

class DeleteProductForm extends Form {

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
        $header = "<h3>" . translate("Delete Products") . "</h3>";
        $html = "";
        foreach (Product::render_deleteProductForm() as $element) {
            $html = $html . $element;
        }
        $submit = "<input type='submit' value='". translate("Delete") ."' name='post_deleteProduct'/>";
        return [$header,
            $html,
            $submit,
            parent::getCancleButton("noDel")];
    }
}

class SearchProductForm extends Form {

    private $load;
    private $method;
    private $URL;
    private $lang;
    private $page;
    private $prodData;

    public function __construct(string $language, string $page = "", $load=false, array $prodData=[]) {
        $this->prodData = $prodData;
        if (!checkAdmin()) {
            createErrorUrl("NotAdminUser");
        }
        parent::__construct($language, $page);
        $this->method = parent::getMethod();
        $this->URL = parent::getUrl();
        $this->lang = $language;
        $this->page = $page;
        parent::setHtml("<form method='$this->method' action='$this->URL'>");
        $this->load = $load;
    }

    public function render() {
        parent::appendContext("<h3>" . translate("Update Product") . "</h3>");
        foreach (Product::render_searchProductForm() as $element) {
            parent::appendContext($element);
        }
        parent::appendContext("<input type='submit' value='". translate("Load") ."' name='post_searchProduct'/>");
        parent::appendContext(parent::getCancleButton("noSearch"));
        $form = parent::render();
        if ($this->load) {
            $formUpdate = new UpdateProductForm($this->lang, $this->page, $this->prodData);
            $form = $form . $formUpdate->render();
        }

        return $form;
    }
}

class UpdateProductForm extends Form {

    private $prodData;

    public function __construct(string $language, string $page = "", array $prodData=[]) {
        $this->prodData = $prodData;
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
        $html = "";
        foreach (Product::render_updateProductForm($this->prodData) as $element) {
            $html = $html . $element;
        }
        $_SESSION['old_name'] = $this->prodData['en'][0];
        $submit = "<input type='submit' value='". translate("Update") ."' name='post_updateProduct'/>";
        return [$html,
            $submit,
            parent::getCancleButton("noUpdate")];
    }
}

class ShoppingcartForm extends Form {

    private $cart;

    public function __construct(string $language, ShoppingCart $cart, string $page = "") {
        $this->cart = $cart;
        parent::__construct($language, $page);
        $method = parent::getMethod();
        $url = parent::getUrl();
        $url = add_param($url, "cart", true);
        parent::setHtml("<form method='$method' action='$url'>");
    }

    public function render() {
        foreach ($this->getFormsElements() as $formsElement) {
            parent::appendContext($formsElement);
        }
        return parent::render();
    }

    private function getFormsElements() {
        $html = "<table>";
        $t_Article = translate("Article");
        $t_Amount = translate("Amount");
        $t_Price = translate("Price");
        $t_Total = translate("Total");
        $t_Add = translate("Add");
        $t_Rem = translate("Remove");
        $tableHeader = "<tr><th>$t_Article</th><th>$t_Amount</th><th>$t_Price</th>
                            <th>$t_Total</th><th>$t_Add</th><th>$t_Rem</th></tr>";
        $html = $html . $tableHeader;
        $total = 0;
        foreach ($this->cart->getItems() as $item => $num) {
            $row_total = 0;
            $product = Product::getSingleProduct(getLanguage(["en", "de"]), $item);
            $name = $product['name'];
            $price = round($product['price'], 1);
            $row_total += round(($price * $num), 1);
            $total += round($row_total, 1);
            $td_name = "<td name='$name'>$name</td>";
            $td_amou = "<td name='amount' id='amount'>$num</td>";
            $td_pric = "<td name='price'>$price</td>";
            $td_tota = "<td name='row_total' id='rowtotal'>$row_total</td>";
            $td_btn_add = "<td id='add'><button type='button' onclick='addMore(\"$name\",\"$price\")' class='button'>"
                . $t_Add . "</button></td>";
            $td_btn_rem = "<td id='remove'><button type='button' onclick='remove(\"$name\", \"$price\")' class='button'>"
                . $t_Rem . "</button></td>";
            $tableRow = "<tr id='$name'>$td_name $td_amou $td_pric $td_tota $td_btn_add $td_btn_rem</tr>";
            $html = $html . $tableRow;
        }

        $html = $html . "<tr><td rowspan='3'></td><td name='total' id='supertotal'>$total</td></tr>";
        $html = $html . "</table>";

        $submit = "<input type='submit' class='button' value='". translate("Checkout") ."' name='cart'/>";
        $url = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", get_param("lang", "en"));
        $cancel = "<a href='$url' class='button'><button type='button'>" . translate("Cancle") . "</button></a>";

        return [$html,
            $submit,
            $cancel];
    }
}