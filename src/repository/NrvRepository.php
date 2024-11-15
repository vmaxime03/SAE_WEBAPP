<?php

namespace Iutnc\Nrv\repository;


use Iutnc\Nrv\classes\Artiste;
use Iutnc\Nrv\classes\Image;
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

    public static int $TRI_DEFAUT = 0;
    public static int $TRI_DATE = 1;
    public static int $TRI_THEME_SOIREE = 2;
    public static int $TRI_LIEU = 3;


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

    /**
     * methode utilisée dans le programme insererImages pour inserer les images de test dans la BD
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
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

    public function addImage(Image $img) : int {
        $query = "INSERT INTO image (id, filetype, description, data) VALUE (NULL, '$img->filetype', '$img->description', ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $img->filetype);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function getSoireeById(int $id) : Soiree|false
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
    public function getLieuById($id) : Lieu|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM lieu WHERE id = '$id'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($result && count($result) == 1) {
            return Lieu::createFromDb($result[0]);
        } else {
            return false;
        }
    }
    public function getSpectableByIdSoiree(int $idSoiree): array
    {

        $stmt = $this->pdo->prepare('SELECT * FROM Spectacle WHERE id_soiree = :idSoiree');
        $stmt->bindParam(':idSoiree', $idSoiree, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getImageByIdLieu($idLieu) : Image|false
    {
        $stmt = $this->pdo->prepare("SELECT image.id, image.filetype, image.description, image.data FROM image, lieu2image WHERE image.id = lieu2image.id_image AND lieu2image.id_lieu = '$idLieu'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($result && count($result) == 1) {
            return Image::createFromDb($result[0]);
        } else {
            return false;
        }
    }
    public function getImageByIdSpectacle($idSpectacle) : Image|false
    {
        $stmt = $this->pdo->prepare("SELECT image.id, image.filetype, image.description, image.data FROM image, spectacle2image WHERE image.id = spectacle2image.id_image AND spectacle2image.id_spectacle = '$idSpectacle'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($result && count($result) == 1) {
            return Image::createFromDb($result[0]);
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

    public function getAllSoiree(int $tri = 0) : array
    {
        $sql = match ($tri) {
            self::$TRI_LIEU => "SELECT soiree.id, soiree.nom, soiree.theme, soiree.date, soiree.tarif, soiree.id_lieu FROM soiree, lieu WHERE soiree.id_lieu = lieu.id ORDER BY lieu.nom;;",
            self::$TRI_THEME_SOIREE =>  "SELECT * FROM soiree ORDER BY soiree.theme;",
            self::$TRI_DATE => "SELECT * FROM soiree ORDER BY soiree.date;",
            default => "SELECT * FROM soiree",
        };
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $r = array();
        foreach ($result as $row) {
            $r[] = Soiree::createFromDb($row);
        }
        return $r;
    }

    public function linkArtisteToSpectacle(int $artiste, int $spectacle) : bool {
        $stmt = $this->pdo->prepare("INSERT INTO spectacle2artiste (id_spectacle, id_artiste) VALUES ($spectacle, $artiste)");
        return $stmt->execute();
    }

    public function linkImageToSpectacle(int $image, int $spectacle) : bool {
        $stmt = $this->pdo->prepare("INSERT INTO spectacle2image (id_spectacle, id_image) VALUES ($spectacle, $image)");
        return $stmt->execute();
    }

    public function annulerSpectacle(int $spectacleid) : bool {
        $query = <<<SQL
UPDATE spectacle
SET est_annule = 1
WHERE id = $spectacleid
SQL;
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute();
    }
}