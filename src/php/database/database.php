<?php

class Database {

    private $servername = "localhost";
    private $username = "admin";
    private $password = "Gugus1234";
    private $database = "aanda";

    public function connect() {
        $conn = new mysqli($this->getServername(), $this->getUsername(), $this->getPassword(), $this->getDatabase());
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    private function getDatabase(): string {
        return $this->database;
    }

    private function getPassword(): string {
        return $this->password;
    }

    private function getServername(): string {
        return $this->servername;
    }

    private function getUsername(): string {
        return $this->username;
    }
}

class Entity {

    private $database;

    private $productQuery = "SELECT p_real.name, product.price, p_real.description FROM product
        JOIN p_real ON product.d_id=p_real.id
        JOIN language on p_real.l_id=language.id
        JOIN p_type on product.p_id=p_type.id
        WHERE language.short LIKE ? and p_type.name LIKE ?";

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getProductsFromDatabase($type, $language) {
        $connection = $this->database->connect();
        $query = $connection->prepare($this->productQuery);
        $query->bind_param('ss', $language, $type);
        $query->execute();
        $result = $query->get_result();
        return $result;
    }
}
