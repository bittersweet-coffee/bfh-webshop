<?php

class Database extends mysqli {

    private CONST SERVERNAME = "localhost";
    private CONST USERNAME = "admin";
    private CONST PASSWORD = "Gugus1234";
    private CONST DATABASE = "aanda";
    static private $instance;

    public function __construct()
    {
        parent::__construct(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DATABASE);
    }

    static public function getDBInstance() {
        if (!self::$instance) {
            @self::$instance = new Database();
        }
        return self::$instance;
    }

    static public function doQueryPrepare($query) {
        return self::getDBInstance()->prepare($query);
    }
}

class Entity {

    private $database;



    public function __construct()
    {
        $this->database = new Database();
    }

    public static function getUsernames() {
        $instance = new self();
        $result = $instance->getDatabaseUsernames();
        return $result;
    }


}
