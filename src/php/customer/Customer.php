<?php

class Customer
{
    private $firstname;
    private $lastname;
    private $address;
    private $postalCode;
    private $email;
    private $country;

    private CONST getCustomerQuery = "SELECT * FROM shopusers
              JOIN contact_users ON shopusers.contact = contact_users.id
              WHERE shopusers.username LIKE ?";

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

    public function render()
    {
        $context =
            "<div id='customer_container'>
                <p><label>Firstname: </label> $this->firstname</p>
                <p><label>Lastname: </label> $this->lastname</p>
                <p><label>Address: </label> $this->address</p>
                <p><label>Email: </label> $this->email</p>
                <p><label>Postal Code: </label> $this->email</p>
                <p><label>Country: </label> $this->country</p>
            </div>";
        return $context;
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
}