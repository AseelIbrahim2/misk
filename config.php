<?php
$host = 'db';        
$dbname = 'db';    
$user = 'db';        
$pass = 'db';        

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connected successfully<br>";


    $stmt = $pdo->query("SELECT DATABASE()"); 
    $currentDb = $stmt->fetchColumn();
    echo "Connected to database: " . $currentDb ."<br>" ;

} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage();
}
