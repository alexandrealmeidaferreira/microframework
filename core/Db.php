<?php
/**
 * A simple database for multiple connection ONLY PDO!
 *
 * User: alexandre
 * Date: 09/12/15
 * Time: 20:11
 */

namespace core;


class Db
{
    private static $_configFile = 'database.php';
    private static $config = array();
    private static $pool = array();

    /**
     * Get a connection from pool
     * 
     * @param string $connection
     * @return \PDO
     * @throws \Exception
     */
    public static function get($connection = '')
    {
        $configFile = self::$_configFile;
        if (defined('APP_ENV')) {
            $configFile = APP_ENV . '.' . self::$_configFile;
        }
        //get the connections
        if (is_file(CONFIG_DIR . $configFile) && empty(self::$config)) {
            self::$config = include CONFIG_DIR . $configFile;
            echo 'getting the configs';
        }

        //if connection not exists then create it
        if (!isset(self::$pool[$connection])) {
            if (isset(self::$config) && !empty(self::$config)) {
                if (isset(self::$config[$connection]) && !empty(self::$config[$connection])) {
                    if (isset(self::$config[$connection]['dsn']) && !empty(self::$config[$connection]['dsn'])) {
                        if (isset(self::$config[$connection]['user']) && !empty(self::$config[$connection]['user'])) {
                            if (isset(self::$config[$connection]['pass']) && !empty(self::$config[$connection]['pass'])) {
                                //if no options just add an empty array
                                if (!isset(self::$config[$connection]['options'])) {
                                    self::$config[$connection]['options'] = array();
                                }
                                echo 'creating pdo connection';
                                //create the connection
                                try {
                                    self::$pool[$connection] = new \PDO(
                                        self::$config[$connection]['dsn'],
                                        self::$config[$connection]['user'],
                                        self::$config[$connection]['pass'],
                                        self::$config[$connection]['options']);

                                    //some attributes
                                    self::$pool[$connection]->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                                    self::$pool[$connection]->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_EMPTY_STRING);
                                } catch (\PDOException $e) {
                                    throw new \Exception('ERROR - Could not connect to database.', 15);
                                }
                            } else {
                                //pass parameter not found
                                throw new \Exception('ERROR - "pass" parameter not found.', 14);
                            }
                        } else {
                            //user paramter not found
                            throw new \Exception('ERROR - "user" parameter not found.', 13);
                        }
                    } else {
                        //dsn parameter not found
                        throw new \Exception('ERROR - "dsn" parameter not found.', 12);
                    }
                } else {
                    //connection passed in parameter not found
                    throw new \Exception('ERROR - Connection "' . $connection . '" not found.', 11);
                }
            } else {
                //empty config
                throw new \Exception('ERROR - Empty database config file.', 10);
            }
        }

        return self::$pool[$connection];
    }
}