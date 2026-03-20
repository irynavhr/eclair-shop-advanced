<?php
class Database
{
    private $host = 'localhost';
    private $dbname = 'webdev_project';
    private $username = 'root';
    private $password = '';
    private $pdo;

    // CONSTRUCTOR
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            // SET ERROR MODE AS EXEPTIONS
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error with database connection: " . $e->getMessage();
            die(); // END IF NO CONNECTION
        }
    }

    // GET CONNECTION METHOD
    public function getConnection()
    {
        return $this->pdo;
    }
}
