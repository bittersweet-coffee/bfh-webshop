<?php

class Customer {
    private $firstname;
    private $lastname;
    private $address;
    private $postalCode;
    private $email;
    private $country;

    public function __construct(string $firstname,
                                string $lastname,
                                string $address,
                                string $postalCode,
                                string $email,
                                string $country)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->address = $address;
        $this->postalCode = $postalCode;
        $this->email = $email;
        $this->country = $country;
    }

    public function render() {
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


}