<?php 

namespace Jusa\Backend\Config;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database 
{
    private PDO $pdo;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        
        try {
            $this->pdo = new PDO('mysql:host=' . $_ENV['DB_HOST']  . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo ("Connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}