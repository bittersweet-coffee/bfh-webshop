<?php
class Customer
{
    private $firstname;
    private $lastname;
    private $address;
    private $postalCode;
    private $email;
    private $country;
    private CONST inputElements = array (
        "Firstname" => "text",
        "Lastname" => "text",
        "Address" => "text",
        "PostalCode" => "text",
        "Email" => "email",
        "Country" => "text"
    );
    private CONST getCustomerQuery = "SELECT * FROM shopusers
              JOIN contact_users ON shopusers.contact = contact_users.id
              WHERE shopusers.username LIKE ?";

    private CONST updateCustomerQuery = "UPDATE contact_users, shopusers SET 
        firstname = ?, 
        lastname = ?, 
        address = ?, 
        postalcode = ?, 
        email = ?, 
        country = ? 
        WHERE shopusers.id = contact_users.id AND shopusers.username LIKE ?";

    public function __construct(string $firstname,
                                string $lastname,
                                string $address,
                                int $postalCode,
                                string $email,
                                string $country)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->address = $address;
        $this->postalCode = intval($postalCode);
        $this->email = $email;
        $this->country = $country;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function getAddress(): string
    {
        return $this->address;
    }
    public function getCountry(): string
    {
        return $this->country;
    }
    public function getPostalCode(): int
    {
        return (int)$this->postalCode;
    }

    public function render()
    {
        $context =
            "<div class='customer_container'>
                <p><label>" . translate("Firstname") . ": </label> $this->firstname</p>
                <p><label>" . translate("Lastname") . ": </label> $this->lastname</p>
                <p><label>" . translate("Address") . ": </label> $this->address</p>
                <p><label>" . translate("Email") . ": </label> $this->email</p>
                <p><label>" . translate("Postal Code") . ": </label> $this->email</p>
                <p><label>" . translate("Country") . ": </label> $this->country</p>
            </div>";
        return $context;
    }

    public function renderMail()
    {
        $context =
            "
                ----" . translate("Firstname") . ": $this->firstname \n
                ----" . translate("Lastname") . ":  $this->lastname \n
                ----" . translate("Address") . ": $this->address \n
                ----" . translate("Email") . ":  $this->email \n
                ----" . translate("Postal Code") . ": $this->email \n
                ----" . translate("Country") . ": $this->country \n
            ";
        return $context;
    }

    public static function render_InputTags(): string {
        $customerInputTag = "<div class='customer_tags'>";
        foreach (self::inputElements as $inputElementName => $inputType) {
            $customerInputTag = $customerInputTag . self::setInputTag($inputType, $inputElementName);
        }
        return $customerInputTag . "</div>";
    }
    private static function setInputTag($type, $name): string {
        $value = checkUserSession($name);
        $cookie = checkCookie($name);
        if ($cookie != '') {
            $value = $cookie;
        }
        $t_name = translate($name);
        $t_mark = translate("can't be empty or is not valid");
        $inputTag = "
            <p id='$name'>
                <label>$t_name: </label>
                <input type='$type' name='$name' value='$value' required>
                <mark>'$t_name' $t_mark</mark>
            </p>
            ";
        return $inputTag;
    }

    public static function getCustomer(string $usr) {
        $query = Database::doQueryPrepare(self::getCustomerQuery);
        $query->bind_param('s', $usr);
        $query->execute();
        $result = $query->get_result();
        if (!$result || $result->num_rows !== 1) {
            return false;
        }
        $row = $result->fetch_assoc();
        return $row;
    }

    public static function updateCustomer(string $usr, string $fname, string $lname, string $addr, int $pc, string $mail, string $cntry) {
        $query = Database::doQueryPrepare(self::updateCustomerQuery);
        $query->bind_param('sssisss', $fname, $lname,$addr,$pc,$mail,$cntry,$usr);
        $query->execute();
        $result = $query->get_result();
        return $result;
    }
}