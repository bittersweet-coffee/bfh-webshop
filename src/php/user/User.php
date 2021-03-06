<?php

class User {

    private CONST usernameQuery = "SELECT shopusers.username FROM shopusers";
    private CONST storeUserQuery = "INSERT INTO `shopusers` 
            (`id`, `username`, `password`, `contact`) 
            VALUES (?, ?, ?, ?);";
    private CONST storeCustomerData = "INSERT INTO `contact_users` 
            (`id`, `firstname`, `lastname`, `address`, `postalcode`, `email`, `country`) 
            VALUES (?, ?, ?, ?, ?, ?, ?);";
    private CONST lastCustomerIDQuery = "SELECT MAX(id) FROM `contact_users`";
    private CONST lastShopUserIDQuery = "SELECT MAX(id) FROM `shopusers`";
    private CONST passwordHashQuery = "SELECT * FROM `shopusers` WHERE `username` LIKE ?";
    private CONST updatePasswordQuery = "UPDATE shopusers SET password = ? WHERE shopusers.username LIKE ?";

    private CONST inputElements = array (
        "Username" => "text",
        "Password" => "password",
        "Retype" => "password",
    );

    private $customer;
    private $username;
    private $password;

    public function __construct(Customer $customer, string $username, string $password = "notSet") {
        $this->customer = $customer;
        $this->username = $username;
        $this->password = password_hash($password,PASSWORD_BCRYPT);
    }

    public static function getDatabaseUsernames() {
        $query = Database::doQueryPrepare(self::usernameQuery);
        $query->execute();
        $result = $query->get_result();
        return $result;
    }

    public  static function getPasswordHash(string $usr, string $pwd) {
        $query = Database::doQueryPrepare(self::passwordHashQuery);
        $query->bind_param('s', $usr);
        $query->execute();
        $result = $query->get_result();
        if (!$result || $result->num_rows !== 1) {
            return false;
        }
        $row = $result->fetch_assoc();
        return password_verify($pwd, $row["password"]);
    }
    public function storeUser() {
        $idContUsers = $this->getLastID(self::lastCustomerIDQuery) + 1;
        $this->storeCustomerData($idContUsers,
            $this->customer->getFirstname(),
            $this->customer->getLastname(),
            $this->customer->getAddress(),
            intval($this->customer->getPostalCode()),
            $this->customer->getEmail(),
            $this->customer->getCountry());
        $idShopUser = $this->getLastID(self::lastShopUserIDQuery) + 1;
        $this->storeUserData($idShopUser,$this->username,$this->password,$idContUsers);
    }

    private function getLastID($query) {
        $query = Database::doQueryPrepare($query);
        $query->execute();
        $res = $query->get_result();
        $row = mysqli_fetch_row($res);
        return $row[0];
    }

    private function storeCustomerData(int $id,
                                       string $fname,
                                       string $lname,
                                       string $adr,
                                       int $pc,
                                       string $mail,
                                       string $country) {
        $query = Database::doQueryPrepare(self::storeCustomerData);
        $query->bind_param('isssiss',
            $id,
            $fname,
            $lname,
            $adr,
            $pc,
            $mail,
            $country);
        $query->execute();
    }

    private function storeUserData($idShopUser, $username, $password, $idContUser) {
        $query = Database::doQueryPrepare(self::storeUserQuery);
        $query->bind_param('issi',$idShopUser,$username, $password, $idContUser);
        $query->execute();
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function toArray() {
        $customer = $this->getCustomer();
        $user = array(
            "username" => $this->getUsername(),
            "firstname" => $customer->getFirstname(),
            "lastname" => $customer->getLastname(),
            "address" => $customer->getAddress(),
            "postalcode" => $customer->getPostalCode(),
            "email" => $customer->getEmail(),
            "country" => $customer->getCountry());
        return $user;
    }

    public function render() {
        $customerContent = $this->customer->render();
        $context =
            "<div id='user_container'>
                <p><label>" . translate("Username") . ": </label> $this->username</p>
                $customerContent
            </div>";
        return $context;
    }

    public static function render_InputTags(): string {
        $userInputTag = "";
        foreach (self::inputElements as $inputElementName => $inputType) {
            $userInputTag = $userInputTag . self::setInputTag($inputType, $inputElementName);
        }
        return $userInputTag;
    }

    private static function setInputTag($type, $name): string {
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

    public static function changePassword($user, $pw) {
        $pw = password_hash($pw,PASSWORD_BCRYPT);
        $query = Database::doQueryPrepare(self::updatePasswordQuery);
        $query->bind_param('ss', $pw,$user);
        $query->execute();
        $result = $query->get_result();
        return $result;

    }
}