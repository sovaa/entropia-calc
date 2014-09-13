<?php

if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');

class Dao {
    public static function insert($dbo, $query, $params = null) {
        Dao::query($dbo, $query, $params);
    }

    public static function update($dbo, $query, $params = null) {
        Dao::query($dbo, $query, $params);
    }
    
    public static function execute($dbo, $query, $params = null) {
        $sth = Dao::query($dbo, $query, $params);
        return $sth->fetchAll();
    }

    private static function query($dbo, $query, $params = null) {
        if (SQL === 'mysql') {
            $sth = $dbo->prepare($query);

            if ($params == null) {
                $sth->execute();
            }
            else {
                $sth->execute($params);
            }

            return $sth;
        }
        else {
            die("unsupported sql language: " . SQL);
        }
    }

    public static function connect($host, $user, $pass, $db) {
        if (SQL === 'mysql') {
            $dao = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $dao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dao;
        }
        else {
            die("unsupported sql language: " . SQL);
        }
    }
}

$dao = Dao::connect('localhost', 'goat-cheese-ham', 'one-hell-of-a-nice-password-ya-know', 'entropia_armory') or die("Error " . mysqli_error($sql));

?>
