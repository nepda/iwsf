<?php

declare(strict_types=1);

namespace IWantSomeFood;

require_once 'vendor/autoload.php';

$pdo = new \PDO('mysql:dbname=eating_test;host=mariadb;port=3306', 'root', 'root-secure');
