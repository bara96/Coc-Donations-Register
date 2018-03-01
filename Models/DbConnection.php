<?php

/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 01/12/15
 * Time: 17:16
 */

//replace with your own
-define('host', 'insert_host');
-define('dbname', 'insert_dbname');
-define('user', 'insert_dbuser');
-define('password', 'insert_password');

class DbConnection {
    private static $db;

    /**
     * Create a connection with db
     * @return PDO
     * @throws Exception
     */
    public static function getConnection() {
        if(!is_object(self::$db)) {
            try {
                self::$db = new PDO('mysql:host=' . host . ';dbname=' . dbname, user, password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(Exception $e) {
                throw new Exception("Database not avaiable");
            }
        }
        return self::$db;
    }

    /**
     * End connection
     */
    function __destruct() {
        self::$db = null;
    }

    /**
     * Return true if db is online, else false
     * @return bool
     */
    public static function isOnline() {
        try {
            $db = self::getConnection();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

}