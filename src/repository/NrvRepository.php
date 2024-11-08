<?php

namespace Iutnc\Nrv\repository;

use Iutnc\Nrv\classes\Artiste;
use Iutnc\Nrv\classes\Lieu;
use Iutnc\Nrv\classes\Soiree;
use Iutnc\Nrv\classes\Spectacle;
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

    public function addUser(User $user) : int
    {
        $stmt = $this->pdo->prepare("INSERT INTO user (id, email, passwd, role) 
                            VALUE (NULL, '$user->email', '$user->passwd', $user->role)");
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function addSoiree(Soiree $soiree) : int
    {
        $t = str_replace( ',', '.', "$soiree->tarif");
        $stmt = $this->pdo->prepare("INSERT INTO soiree (id, nom, theme, date, tarif, id_lieu) 
                                VALUE (NULL, '$soiree->nom', '$soiree->theme', '$soiree->date', $t, $soiree->idLieu)");
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function addSpectacle(Spectacle $spectacle) : int
    {
        $stmt = $this->pdo->prepare("INSERT INTO spectacle (id, titre, description, heure, duree, libelleStyle, video, id_soiree, est_annule)
                                VALUE (NULL, '$spectacle->titre', '$spectacle->description', '$spectacle->heure', '$spectacle->duree', 
                                      '$spectacle->style', '$spectacle->videoUrl', '$spectacle->idSoiree', 0)");
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function addArtiste(Artiste $artiste) : int {
        $stmt = $this->pdo->prepare("INSERT INTO artiste (id, Nom, info) VALUE (NULL, '$artiste->nom', '$artiste->info')");
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function getSoireeById($id) : Soiree|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM soiree WHERE id = '$id'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($result && count($result) == 1) {
            return Soiree::createFromDb($result[0]);
        } else {
            return false;
        }
    }
    public function getImageSoireeById($id) : Soiree|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM soiree WHERE image.id = '$id'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($result && count($result) == 1) {
            return Soiree::createFromDb($result[0]);
        } else {
            return false;
        }
    }

    public function getAllLieu() : array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM lieu");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $r = array();
        foreach ($result as $row) {
            $r[] = Lieu::createFromDb($row);
        }
        return $r;

    }
    public function getAllSpectacle() : array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM spectacle");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $r = array();
        foreach ($result as $row) {
            $r[] = Spectacle::createFromDb($row);
        }
        return $r;

    }
    public function getAllArtiste() : array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM artiste");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $r = array();
        foreach ($result as $row) {
            $r[] = Artiste::createFromDb($row);
        }
        return $r;
    }

    public function getAllSoiree() : array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM soiree");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $r = array();
        foreach ($result as $row) {
            $r[] = Soiree::createFromDb($row);
        }
        return $r;

    }
}