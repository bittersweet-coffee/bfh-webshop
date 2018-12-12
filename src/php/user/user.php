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

    private $customer;
    private $username;
    private $password;

    public function __construct(Customer $customer, string $username, string $password) {
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

    public function storeUser() {
        $idContUsers = $this->getLastID(self::lastCustomerIDQuery) + 1;
        $this->storeCustomerData($idContUsers,
            $this->customer->getFirstname(),
            $this->customer->getLastname(),
            $this->customer->getEmail(),
            $this->customer->getAddress(),
            intval($this->customer->getPostalCode()),
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
                                       string $mail,
                                       string $adr,
                                       int $pc,
                                       string $country) {
        $query = Database::doQueryPrepare(self::storeCustomerData);
        $query->bind_param('issssis',
            $id,
            $fname,
            $lname,
            $mail,
            $adr,
            $pc,
            $country);
        $query->execute();
    }

    private function storeUserData($idShopUser, $username, $password, $idContUser) {
        $query = Database::doQueryPrepare(self::storeUserQuery);
        $query->bind_param('issi',$idShopUser,$username, $password, $idContUser);
        $query->execute();
    }
}