<?php

namespace OCFramework;
use \PDO;
use \mysqli;

class DBConnectionFactory
{
    public static function getPDO()
    {
      $db = new PDO('mysql:host=localhost;dbname=testocr', 'root', '');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db->exec("SET NAMES 'utf8';");

      return $db;
    }

    public static function getMySQL()
    {
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $db = new mysqli('localhost', 'root', '', 'testocr');

      if ($db->connect_error)
      {
        echo 'Error: Cannot connect to Database. Errno: ' .$db->connect_errno. PHP_EOL;
        echo 'Message: ' .$db->connect_error. PHP_EOL;
        exit;
      }

      return $db;
    }
}