<?php
$host = 'localhost';      
$db   = 'db_rumahsakit';  
$user = 'postgres';          
$pass = '123456';               
$charset = 'utf8';     

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$user;password=$pass";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>