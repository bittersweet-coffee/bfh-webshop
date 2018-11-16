<?php
function getPageContent($name) {
    switch ((isset($_GET[$name]) ? $_GET[$name] : '')) {
        case 'rods':
            echo "<p> rods </p>";
            displayProducts('Fishing Rods');
            break;
        case 'reels':
            echo "<p> reels </p>";
            displayProducts('Reels');
            break;
        case 'lures':
            echo "<p> lures </p>";
            displayProducts('Lures');
            break;
        case 'lines':
            echo "<p> lines </p>";
            displayProducts('Fishing Lines');
            break;
        case 'accessories':
            echo "<p> accessories </p>";
            displayProducts('Accessories');
            break;
        case 'about':
            echo "<p> about </p>";
            break;
        case 'login':
            echo "<p> login </p>";
            break;
        case 'buy':
            echo "<p> buy </p>";
            displayBuy();
            break;
        case 'shipping':
            echo "<p> shipping </p>";
            displayShipping();
            break;
        default:
            displayProducts('Fishing Rods');
            displayProducts('Reels');
            displayProducts('Lures');
            displayProducts('Fishing Lines');
            displayProducts('Accessories');
            break;
    }
}
function displayNav($pages) {

    echo "<nav><ul>";
    $lang=getLanguage($pages);
    $urlbase = $_SERVER['PHP_SELF'] . "?lang=$lang";
    foreach ($pages[$lang] as $key => $page) {
        $url = $urlbase . "&page=$page[1]";
        echo "<li class=\"$page[0]\"><a href=\"$url\" alt=\"$page[1]\">$page[2]</a></li>";
    }
    foreach ($pages as $key => $l) {
        if (isset($_GET["page"])) {
            $url = $_SERVER['PHP_SELF'] . "?lang=$key" . "&page=" . $_GET["page"];
            echo "<li class=\"nav-right\"><a href=\"$url\" alt=\"$key\">";
            echo strtoupper($key) . "</a></li>";
        } else {
            $url = $_SERVER['PHP_SELF'] . "?lang=$key";
            echo "<li class=\"nav-right\"><a href=\"$url\" alt=\"$key\">";
            echo strtoupper($key) . "</a></li>";
        }
    }
    echo "</nav></ul>";
}

function getLanguage($lang) {
    $default = "en";
    foreach ($lang as $key => $l) {
        if (isset($_GET["lang"])) {
            return $_GET["lang"];
        }
    }
    return $default;

}

function displayProducts($type) {
    $products = getProducts($type);
    echo "<div id='container'>";
    foreach ($products as $key => $product) {
        $lang = getLanguage(["en", "de"]);
        $page = "buy";
        $url = $_SERVER['PHP_SELF'] . "?lang=$lang" . "&page=$page";
        echo "<div id='box'>
                <form method=\"POST\" action=$url>
                    <p>Name:$key</p>
                    <input type=\"hidden\" name=\"name\" value=\"$key\">
                    <p>Price: $product[0]</p>
                    <input type=\"hidden\" name=\"price\" value=\"$product[0]\">
                    <p>Description: $product[1]</p>
                    <input type=\"hidden\" name=\"description\" value=\"$product[1]\">
                    <input type=\"submit\" value=\"buy now\" name=\"buy\" /> 
                </form>
            </div>";
    }
    echo "</div>";
}

function getProducts($type) {
    $db = connect();
    $lang = getLanguage(["en", "de"]);
    $query = $db->prepare("SELECT p_real.name, product.price, p_real.description FROM product
        JOIN p_real ON product.d_id=p_real.id
        JOIN language on p_real.l_id=language.id
        JOIN p_type on product.p_id=p_type.id
        WHERE language.short LIKE ? and p_type.name LIKE ?");
    $query->bind_param('ss', $lang, $type);
    $query->execute();
    $result = $query->get_result();
    $products = array();
    while($row = mysqli_fetch_row($result)) {
        $key = $row[0];
        $value = array($row[1], $row[2]);
        $products[$key] = $value;
    }



    return $products;
}

function displayBuy() {
    $lang = getLanguage(["en", "de"]);
    $page = "shipping";
    $url = $_SERVER['PHP_SELF'] . "?lang=$lang" . "&page=$page";
    $html = "<form method=\"POST\" action=" . $url . ">";
    if ((isset($_POST["name"]))) {
        $name = $_POST['name'];
        $html = $html . "<p> NAME: $name </p>";
        $html = $html . "<input type=\"hidden\" name=\"name\" value=\"$name\">";
    }
    if ((isset($_POST["price"]))) {
        $price = $_POST['price'];
        $html = $html . "<p>Price: $price </p>";
        $html = $html . "<input type=\"hidden\" name=\"price\" value=\"$price\">";
    }
    if ((isset($_POST["description"]))) {
         $description = $_POST['description'];
        $html = $html . "<p>DESC: $description </p>";
        $html = $html . "<input type=\"hidden\" name=\"description\" value=\"$description\">";
    }
    $donation = 5.0;
    $html = $html . "
            How many would you like? <input name=\"number\" type=\"number\" value=\"1\">
            <br>
            <p> Donation of " . $donation . ".- to \"Safe A Fisherman\":</p>
            <input type=\"hidden\" name=\"don\" value=\"$donation\">
            <input type=\"radio\" name=\"donation\" value=\"ok\"> Yes, good thing! <br>
            <input type=\"radio\" name=\"donation\" value=\"nok\" checked=\"checked\"> No Thanks. <br>
            <input type=\"submit\" value=\"ship that shit\" name=\"ship\" />
        </form>";
    echo $html;
}

function displayShipping(){
    $lang = getLanguage(["en", "de"]);
    $page = "confirmation";
    $url = $_SERVER['PHP_SELF'] . "?lang=$lang" . "&page=$page";
    $html = "<pre><form method=\"POST\" action=" . $url . "id=\"customerform\">";
    $html = $html . "<h3>Purchase Information </h3>";
    $html = $html . "\n     Product Name: " . $_POST['name'];
    $html = $html . "\n     Description: " . $_POST['description'];
    $html = $html . "\n     Price per piece: " . $_POST['price'];
    $html = $html . "\n     Amount: " . $_POST['number'];
    if ($_POST['donation'] == "ok") {
        $html = $html . "\n     Donation: " . $_POST['don'] . ".-";
        $html = $html . "\n     Thanks for the donation of to \"Safe A Fisherman\"";
    }
    $html = $html . "<h3> Customer Information </h3>";
    $html = $html . "
        First name: 
        <input type=\"text\" name=\"firstname\"> \n
        Last name:
        <input type=\"text\" name=\"lastname\"><br>
        E-Mail: 
        <input type=\"email\" name=\"email\"><br>
        Address: 
        <input type=\"text\" name=\"address\"><br>
        Postal code: 
        <input type=\"text\" name=\"postalCode\"><br>
        Country:
        <input type=\"text\" name=\"country\"><br>
        Payment Method: 
        <select id=\"billId\" onchange=\"getBillDiv()\">
            <option value=\"\"></option>
            <option value=\"card\">Credit card</option>
            <option value=\"paper\">Paper bill</option>
        </select>
        <div class='hidden' id='card'>
            <h5> Credit Card Information </h5>
            Name on the Card: 
            <input type=\"text\" name=\"card_name\">
            Number: 
            <input type=\"text\" name=\"card_number\">
            CVV:
            <input type=\"text\" name=\"card_cvv\">
        </div>
        <div class='hidden' id='paper'>
            <h5> Billing Address </h5>
            <input type=\"checkbox\" name=\"sameAddress\" value=\"address\">  Billing Address is the same as Customer Address
            First name: 
            <input type=\"text\" name=\"bill_firstname\">
            Last name:
            <input type=\"text\" name=\"bill_lastname\">
            Address: 
            <input type=\"text\" name=\"bill_address\">
            Postal code: 
            <input type=\"text\" name=\"bill_postalCode\">
        </div>";
    $html = $html . "</form>
    Leave Some Comments here:
    <textarea rows=\"4\" cols=\"50\" name=\"comment\" form=\"customerform\"></textarea>
    </pre>";
    echo $html;

}

function connect() {
    $servername = "localhost";
    $username = "admin";
    $password = "Gugus1234";
    $database = "aanda";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}