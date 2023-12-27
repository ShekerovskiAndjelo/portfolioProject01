<?php
require_once('../../Connection/connection.php');

$adminUsers = [
    ['username' => 'admin1', 'password' => password_hash('password1', PASSWORD_DEFAULT), 'email' => 'admin1@example.com', 'is_admin' => '1'],
    ['username' => 'admin2', 'password' => password_hash('password2', PASSWORD_DEFAULT), 'email' => 'admin2@example.com', 'is_admin' => '1'],
];

$database = new Database(); 

$connection = $database->connection;

foreach ($adminUsers as $adminUser) {
    $username = $adminUser['username'];
    $password = $adminUser['password'];
    $email = $adminUser['email'];
    $is_admin = $adminUser['is_admin'];

    $statement = $connection->prepare("INSERT INTO users (username, password, email, is_admin) VALUES (:username, :password, :email, :is_admin)");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $password);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':is_admin', $is_admin);

    $statement->execute();
}

echo "Admin users imported successfully.";
?>
