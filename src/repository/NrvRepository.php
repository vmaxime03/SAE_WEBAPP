<?php

namespace Iutnc\Nrv\repository;

use Iutnc\Nrv\classes\User;
use PDO;

class NrvRepository
{
    private PDO $pdo;
    private static ?NrvRepository $instance;
    private static array $config = [ ];

    private function __construct(array $config) {
        $dsn = "".$config['driver'].":host=".$config['host'].";dbname=".$config['database'];
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
    }

    public static function getInstance(): NrvRepository {
        if (!isset(self::$instance)) {
            self::$instance = new NrvRepository(self::$config);
        }
        return self::$instance;
    }

    public static function setConfig(string $file): void {
        self::$config = parse_ini_file($file);
    }

    //TODO

    public function getUserByEmail(string $email) : User|false {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = '$email'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($result && count($result) == 1) {
            return User::createFromDb($result[0]);
        } else {
            return false;
        }
    }

    public function getUserById(int $id) : User|false {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE id = $id");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($result && count($result) == 1) {
            return User::createFromDb($result[0]);
        } else {
            return false;
        }
    }

    public function addUser(User $user) : void
    {
        $stmt = $this->pdo->prepare("INSERT INTO user (id, email, passwd, role) VALUES (NULL, '$user->email', '$user->passwd', $user->role)");
        $stmt->execute();
    }
}