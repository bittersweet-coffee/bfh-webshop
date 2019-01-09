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

    //singleton
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
