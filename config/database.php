<?php

/**
 * Database configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * driver =>
 * mysql, postgres, sqlite, adodb, pear-drivername
 *
 * connect =>
 * MySQL set the connect to either mysql_pconnect of mysql_connect
 * PostgreSQL set the connect to either pg_pconnect of pg_connect
 * SQLite set the connect to sqlite_popen  sqlite_open
 * ADOdb set the connect to one of these
 *  (http://phplens.com/adodb/supported.databases.html) and
 *  append it '|p' for persistent connection. (mssql|p for example, or just mssql for not persistent)
 *
 * host =>
 * the host you connect to the database
 * MySQL 'localhost' to add a port number use 'localhost:port#'
 * PostgreSQL 'localhost' to add a port number use 'localhost port=5432'
 *
 */
class DATABASE_CONFIG
{
    var $default = array('driver' => 'mysql',
                                'connect' => 'mysql_connect',
                                'host' => 'localhost',
                                'login' => 'your_login',
                                'password' => 'your_password',
                                'database' => 'your_database',
                                'prefix' => '');

    var $test = array('driver' => 'mysql',
                                'connect' => 'mysql_connect',
                                'host' => 'localhost',
                                'login' => 'your_login',
                                'password' => 'your_password',
                                'database' => 'your_database_test',
                            'prefix' => '');
}
?>